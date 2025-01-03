<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
<meta name="theme-color" content="#222">
<meta name="generator" content="Hexo 7.3.0">
  <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
  <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg" color="#222">
  <link rel="manifest" href="/images/favicon/site.webmanifest">
  <meta name="msapplication-config" content="/images/favicon/browserconfig.xml">

<link rel="stylesheet" href="/css/main.css">

<link rel="stylesheet" href="https://fonts.loli.net/css?family=Lato:300,300italic,400,400italic,700,700italic|Roboto Slab:300,300italic,400,400italic,700,700italic|Roboto Mono:300,300italic,400,400italic,700,700italic&display=swap&subset=latin,latin-ext">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.2.5/dist/jquery.fancybox.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-progress@1.0.2/themes/blue/pace-theme-flash.min.css">
  <script src="https://cdn.jsdelivr.net/npm/pace-progress@1.0.2/pace.min.js"></script>

<script id="hexo-configurations">
    var NexT = window.NexT || {};
    var CONFIG = {"hostname":"shitsurei.online","root":"/","scheme":"Muse","version":"8.0.0-rc.2","exturl":false,"sidebar":{"position":"right","display":"hide","padding":18,"offset":12,"onmobile":false},"copycode":{"enable":false,"show_result":false,"style":null},"back2top":{"enable":true,"sidebar":false,"scrollpercent":false},"bookmark":{"enable":false,"color":"#222","save":"auto"},"fancybox":true,"mediumzoom":false,"lazyload":true,"pangu":false,"comments":{"style":"tabs","active":null,"storage":true,"lazyload":false,"nav":null},"algolia":{"hits":{"per_page":10},"labels":{"input_placeholder":"Search for Posts","hits_empty":"We didn't find any results for the search: ${query}","hits_stats":"${hits} results found in ${time} ms"}},"localsearch":{"enable":true,"trigger":"auto","top_n_per_article":1,"unescape":false,"preload":false},"motion":{"enable":true,"async":false,"transition":{"post_block":"perspectiveLeftIn","post_header":"fadeIn","post_body":"fadeIn","coll_header":"perspectiveLeftIn","sidebar":"slideUpIn"}},"path":"search.xml"};
  </script>

  <meta name="description" content="PHP中的异常处理（广义）和其他语言有些不同，在PHP中，最初时没有异常处理机制的，只有自身的错误处理机制，用来处理脚本编译运行过程中出现的语法错误和运行环境问题，根据错误的严重程度分为不同的级别；后来在引入异常处理机制的过程中为了和已有的错误处理机制不冲突，就将PHP中的异常处理设定为只能捕获用户自定义的异常，而对于编译过程中的语法问题，PHP默认由自身的错误处理机制处理，用户无法进行捕获，这样">
<meta property="og:type" content="article">
<meta property="og:title" content="PHP学习笔记4">
<meta property="og:url" content="https://shitsurei.online/php4">
<meta property="og:site_name" content="shitsurei">
<meta property="og:description" content="PHP中的异常处理（广义）和其他语言有些不同，在PHP中，最初时没有异常处理机制的，只有自身的错误处理机制，用来处理脚本编译运行过程中出现的语法错误和运行环境问题，根据错误的严重程度分为不同的级别；后来在引入异常处理机制的过程中为了和已有的错误处理机制不冲突，就将PHP中的异常处理设定为只能捕获用户自定义的异常，而对于编译过程中的语法问题，PHP默认由自身的错误处理机制处理，用户无法进行捕获，这样">
<meta property="og:locale" content="zh_CN">
<meta property="article:published_time" content="2018-11-02T07:01:25.000Z">
<meta property="article:modified_time" content="2018-11-02T08:45:17.586Z">
<meta property="article:author" content="GuoRong Zhang">
<meta property="article:tag" content="错误处理">
<meta property="article:tag" content="异常处理">
<meta name="twitter:card" content="summary">

<link rel="canonical" href="https://shitsurei.online/php4">


<script id="page-configurations">
  // https://hexo.io/docs/variables.html
  CONFIG.page = {
    sidebar: "",
    isHome : false,
    isPost : true,
    lang   : 'zh-CN'
  };
</script>

  <title>PHP学习笔记4 | shitsurei</title>
  






  <noscript>
  <style>
  .use-motion .brand,
  .use-motion .menu-item,
  .sidebar-inner,
  .use-motion .post-block,
  .use-motion .pagination,
  .use-motion .comments,
  .use-motion .post-header,
  .use-motion .post-body,
  .use-motion .collection-header { opacity: initial; }

  .use-motion .site-title,
  .use-motion .site-subtitle {
    opacity: initial;
    top: initial;
  }

  .use-motion .logo-line-before i { left: initial; }
  .use-motion .logo-line-after i { right: initial; }
  </style>
</noscript>

</head>

<body itemscope itemtype="http://schema.org/WebPage">
  <div class="container use-motion">
    <div class="headband"></div>

    <header class="header" itemscope itemtype="http://schema.org/WPHeader">
      <div class="header-inner"><div class="site-brand-container">
  <div class="site-nav-toggle">
    <div class="toggle" aria-label="切换导航栏">
        <span class="toggle-line toggle-line-first"></span>
        <span class="toggle-line toggle-line-middle"></span>
        <span class="toggle-line toggle-line-last"></span>
    </div>
  </div>

  <div class="site-meta">

    <a href="/" class="brand" rel="start">
      <span class="logo-line-before"><i></i></span>
      <h1 class="site-title">shitsurei</h1>
      <span class="logo-line-after"><i></i></span>
    </a>
      <p class="site-subtitle" itemprop="description">失礼しました</p>
  </div>

  <div class="site-nav-right">
    <div class="toggle popup-trigger">
        <i class="fa fa-search fa-fw fa-lg"></i>
    </div>
  </div>
</div>



<nav class="site-nav">
  <ul id="menu" class="main-menu menu">
        <li class="menu-item menu-item-home">

    <a href="/" rel="section"><i class="fa fa-home fa-fw"></i>首页</a>

  </li>
        <li class="menu-item menu-item-categories">

    <a href="/categories/" rel="section"><i class="fa fa-th fa-fw"></i>分类</a>

  </li>
        <li class="menu-item menu-item-排行">

    <a href="/top/" rel="section"><i class="fa fa-heartbeat fa-fw"></i>排行</a>

  </li>
        <li class="menu-item menu-item-archives">

    <a href="/archives/" rel="section"><i class="fa fa-archive fa-fw"></i>归档</a>

  </li>
        <li class="menu-item menu-item-tags">

    <a href="/tags/" rel="section"><i class="fa fa-tags fa-fw"></i>标签</a>

  </li>
        <li class="menu-item menu-item-about">

    <a href="/about/" rel="section"><i class="fa fa-user fa-fw"></i>关于</a>

  </li>
      <li class="menu-item menu-item-search">
        <a role="button" class="popup-trigger"><i class="fa fa-search fa-fw"></i>搜索
        </a>
      </li>
  </ul>
</nav>



  <div class="search-pop-overlay">
    <div class="popup search-popup">
        <div class="search-header">
  <span class="search-icon">
    <i class="fa fa-search"></i>
  </span>
  <div class="search-input-container">
    <input autocomplete="off" autocapitalize="off"
           placeholder="搜索..." spellcheck="false"
           type="search" class="search-input">
  </div>
  <span class="popup-btn-close">
    <i class="fa fa-times-circle"></i>
  </span>
</div>
<div id="search-result">
  <div id="no-result">
    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
  </div>
</div>

    </div>
  </div>

</div>
    </header>

    
  <div class="back-to-top">
    <i class="fa fa-arrow-up"></i>
    <span>0%</span>
  </div>


    <main class="main">
      <div class="main-inner">
        <div class="content-wrap">
          

          <div class="content post posts-expand">
            

    
  
  
  <article itemscope itemtype="http://schema.org/Article" class="post-block" lang="zh-CN">
    <link itemprop="mainEntityOfPage" href="https://shitsurei.online/php4">

    <span hidden itemprop="author" itemscope itemtype="http://schema.org/Person">
      <meta itemprop="image" content="https://shitsurei-pictures.oss-cn-beijing.aliyuncs.com/pics/avatar.jpg">
      <meta itemprop="name" content="GuoRong Zhang">
      <meta itemprop="description" content="个人博客小站">
    </span>

    <span hidden itemprop="publisher" itemscope itemtype="http://schema.org/Organization">
      <meta itemprop="name" content="shitsurei">
    </span>
      <header class="post-header">
        <h1 class="post-title" itemprop="name headline">
          PHP学习笔记4
        </h1>

        <div class="post-meta">
            <span class="post-meta-item">
              <span class="post-meta-item-icon">
                <i class="far fa-calendar"></i>
              </span>
              <span class="post-meta-item-text">发表于</span>
              

              <time title="创建时间：2018-11-02 15:01:25 / 修改时间：16:45:17" itemprop="dateCreated datePublished" datetime="2018-11-02T15:01:25+08:00">2018-11-02</time>
            </span>
            <span class="post-meta-item">
              <span class="post-meta-item-icon">
                <i class="far fa-folder"></i>
              </span>
              <span class="post-meta-item-text">分类于</span>
                <span itemprop="about" itemscope itemtype="http://schema.org/Thing">
                  <a href="/categories/PHP/" itemprop="url" rel="index"><span itemprop="name">PHP</span></a>
                </span>
            </span>

          

        </div>
      </header>

    
    
    
    <div class="post-body" itemprop="articleBody">

      
        <p>PHP中的异常处理（广义）和其他语言有些不同，在PHP中，最初时没有异常处理机制的，只有自身的错误处理机制，用来处理脚本编译运行过程中出现的语法错误和运行环境问题，根据错误的严重程度分为不同的级别；后来在引入异常处理机制的过程中为了和已有的错误处理机制不冲突，就将PHP中的异常处理设定为只能捕获用户自定义的异常，而对于编译过程中的语法问题，PHP默认由自身的错误处理机制处理，用户无法进行捕获，这样两种机制各司其职，分别应对不同的情况。相比于其它语言中将所有运行中的错误都当做异常来处理，PHP的异常处理机制学习起来较为繁琐。</p>
<span id="more"></span>

<h2 id="错误处理"><a href="#错误处理" class="headerlink" title="错误处理"></a>错误处理</h2><h3 id="错误级别"><a href="#错误级别" class="headerlink" title="错误级别"></a>错误级别</h3><table>
<thead>
<tr>
<th align="center">值</th>
<th align="center">常量名</th>
<th align="center">描述</th>
<th align="center">举例</th>
</tr>
</thead>
<tbody><tr>
<td align="center">1</td>
<td align="center">E_ERROR</td>
<td align="center">这类错误一般不可恢复，例如内存分配导致的问题。导致脚本终止不再继续运行。</td>
<td align="center">Error：Invalid parameters. Invalid parameter name</td>
</tr>
<tr>
<td align="center">2</td>
<td align="center">E_WARNING</td>
<td align="center">运行时警告 (非致命错误)。脚本不会终止运行。</td>
<td align="center">Warning: require_once</td>
</tr>
<tr>
<td align="center">4</td>
<td align="center">E_PARSE</td>
<td align="center">编译时语法解析错误。如字符、变量或结束的地方写规范有误。</td>
<td align="center">Parse error: syntax error, unexpected $end in</td>
</tr>
<tr>
<td align="center">8</td>
<td align="center">E_NOTICE</td>
<td align="center">运行时通知。如变量未定义等。</td>
<td align="center">Notice: Undefined variable: p in E:index.php on line 17</td>
</tr>
<tr>
<td align="center">16</td>
<td align="center">E_CORE_ERROR</td>
<td align="center">在PHP初始化启动过程中发生的致命错误。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">32</td>
<td align="center">E_CORE_WARNING</td>
<td align="center">PHP初始化启动过程中发生的警告 (非致命错误) 。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">64</td>
<td align="center">E_COMPILE_ERROR</td>
<td align="center">致命编译时错误。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">128</td>
<td align="center">E_COMPILE_WARNING</td>
<td align="center">编译时警告 (非致命错误)。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">256</td>
<td align="center">E_USER_ERROR</td>
<td align="center">用户产生的错误信息。由用户使用PHP函数 trigger_error() 产生。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">512</td>
<td align="center">E_USER_WARNING</td>
<td align="center">用户产生的警告信息。由用户使用PHP函数 trigger_error() 产生。</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">1024</td>
<td align="center">E_USER_NOTICE</td>
<td align="center">用户产生的通知信息。由用户使用PHP函数 trigger_error() 产生。</td>
<td align="center"></td>
</tr>
</tbody></table>
<h3 id="三种错误处理方式"><a href="#三种错误处理方式" class="headerlink" title="三种错误处理方式"></a>三种错误处理方式</h3><ul>
<li>die函数</li>
</ul>
<blockquote>
<p>die()语句，可以输出提示信息后退出，不再执行之后的代码</p>
</blockquote>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br></pre></td><td class="code"><pre><span class="line"><span class="keyword">if</span> (!<span class="title function_ invoke__">file_exists</span>(<span class="string">&quot;filename&quot;</span>)) &#123;</span><br><span class="line">	<span class="comment">#die(&quot;diediedie&quot;);//diediedie</span></span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#简洁写法</span></span><br><span class="line"><span class="title function_ invoke__">file_exists</span>(<span class="string">&quot;filename&quot;</span>) <span class="keyword">or</span> <span class="keyword">die</span>(<span class="string">&quot;over&quot;</span>);<span class="comment">//over</span></span><br></pre></td></tr></table></figure>

<ul>
<li>自定义错误处理</li>
</ul>
<p>1.自定义错误处理器，用于处理系统错误</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#创建自定义错误函数（处理器）</span></span><br><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">my_error</span>(<span class="params"><span class="variable">$error_level</span>,<span class="variable">$error_mess</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;	&lt;font size=&#x27;5&#x27; color=&#x27;red&#x27;&gt;<span class="subst">$error_level</span>&lt;/font&gt;&lt;br/&gt;&quot;</span>;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;错误信息:<span class="subst">$error_mess</span>&quot;</span>;</span><br><span class="line">	<span class="keyword">exit</span>();</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#改写回调函数 set_error_handler 处理器，改变系统默认的错误处理函数</span></span><br><span class="line"><span class="comment">#第一个参数是错误函数名，第二个参数是错误级别</span></span><br><span class="line"><span class="title function_ invoke__">set_error_handler</span>(<span class="string">&quot;my_error&quot;</span>,E_WARNING);</span><br><span class="line"></span><br><span class="line"><span class="comment">#$fp=fopen(&quot;aaa.php&quot;, &quot;r&quot;);//2(5号红色字体) 错误信息:fopen(aaa.php): failed to open stream: No such file or directory</span></span><br></pre></td></tr></table></figure>

<p>2.自定义错误触发器，用于处理逻辑错误</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#trigger_error(&quot;业务逻辑不合理&quot;);//Notice: 业务逻辑不合理 in F:\work\php_workspace\错误异常处理1.php on line 59</span></span><br><span class="line"><span class="comment">#创建自定义错误函数</span></span><br><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">my_error2</span>(<span class="params"><span class="variable">$error_level</span>,<span class="variable">$error_mess</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;&lt;font size=&#x27;3&#x27; color=&#x27;green&#x27;&gt;<span class="subst">$error_level</span>&lt;/font&gt;&lt;br/&gt;&quot;</span>;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;错误信息:<span class="subst">$error_mess</span>&quot;</span>;</span><br><span class="line">	<span class="keyword">exit</span>();</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#设置修改系统默认的错误触发器</span></span><br><span class="line"><span class="title function_ invoke__">set_error_handler</span>(<span class="string">&quot;my_error2&quot;</span>,E_USER_NOTICE);</span><br><span class="line"><span class="title function_ invoke__">trigger_error</span>(<span class="string">&quot;业务逻辑不合理&quot;</span>);<span class="comment">//1024(3号绿色字体) 错误信息:业务逻辑不合理</span></span><br><span class="line"><span class="comment">#注意，trigger_error默认的错误级别是E_USER_NOTICE，，当set_error_handler设置的错误级别不是E_USER_NOTICE时，trigger_error函数需要指明</span></span><br><span class="line"><span class="title function_ invoke__">set_error_handler</span>(<span class="string">&quot;my_error2&quot;</span>,E_USER_WARNING);</span><br><span class="line"><span class="title function_ invoke__">trigger_error</span>(<span class="string">&quot;业务逻辑不合理&quot;</span>,E_USER_WARNING);<span class="comment">//512(3号绿色字体) 错误信息:业务逻辑不合理</span></span><br></pre></td></tr></table></figure>

<div class="note info"><p>总结，自定义错误处理时需要厘清以下要点：
1. 自定义的错误属于系统错误还是业务逻辑错误，前者采用错误处理器，使用不带_USER的错误级别；后者采用错误触发器，使用带_USER的错误级别
2. 需要输出哪些错误信息和说明
3. 错误的严重程度如何，发生错误提示后是否还要继续执行之后的代码，即是否用exit函数中断程序

</p></div>

<ul>
<li>错误日志</li>
</ul>
<p>PHP支持向服务器的错误记录系统或文件发送错误日志，包括本地保存和远程发送，默认错误日志输出信息的在php.in中的error_log配置，也可以通过在自定义错误函数中设置error_log()函数实现</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br><span class="line">19</span><br></pre></td><td class="code"><pre><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">my_error3</span>(<span class="params"><span class="variable">$error_level</span>,<span class="variable">$error_mess</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="title function_ invoke__">date_default_timezone_set</span>(<span class="string">&quot;PRC&quot;</span>);</span><br><span class="line">	<span class="variable">$error_info</span>=<span class="string">&quot;错误时间：&quot;</span>.<span class="title function_ invoke__">date</span>(<span class="string">&quot;Y-m-d G:i:s&quot;</span>).<span class="string">&quot;\t错误号：&quot;</span>.<span class="variable">$error_level</span>.<span class="string">&quot;--&quot;</span>.<span class="variable">$error_mess</span>;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;错误信息已保存至\myerror.txt&quot;</span>;</span><br><span class="line">	<span class="comment">#第一个参数是要输出的错误信息，第二个参数是错误信息发送位置，第三个参数取决于第二个参数，设置发送的目的地地址</span></span><br><span class="line">	<span class="comment">/*</span></span><br><span class="line"><span class="comment">	0 message 发送到 PHP 的系统日志，使用操作系统的日志机制或者一个文件，取决于 error_log 指令设置了什么。这是个默认的选项。  </span></span><br><span class="line"><span class="comment">	1 message 发送到参数 destination 设置的邮件地址。第四个参数 extra_headers 只有在这个类型里才会被用到。  </span></span><br><span class="line"><span class="comment">	2 不再是一个选项。  </span></span><br><span class="line"><span class="comment">	3 message 被发送到位置为 destination 的文件里。字符 message 不会默认被当做新的一行。  </span></span><br><span class="line"><span class="comment">	4 message 直接发送到 SAPI 的日志处理程序中。  </span></span><br><span class="line"><span class="comment">	*/</span></span><br><span class="line">	<span class="title function_ invoke__">error_log</span>(<span class="variable">$error_info</span>.<span class="string">&quot;\r\n&quot;</span>,<span class="number">3</span>,<span class="string">&quot;myerror.txt&quot;</span>);</span><br><span class="line">	<span class="keyword">exit</span>();</span><br><span class="line">&#125;</span><br><span class="line"><span class="title function_ invoke__">set_error_handler</span>(<span class="string">&quot;my_error3&quot;</span>,E_USER_WARNING);</span><br><span class="line"><span class="title function_ invoke__">trigger_error</span>(<span class="string">&quot;错误日志测试&quot;</span>,E_USER_WARNING);<span class="comment">//错误信息已保存至\myerror.txt</span></span><br><span class="line"><span class="comment">#当前文件目录下的myerror.txt文件追加信息：错误号是：512--错误日志测试</span></span><br></pre></td></tr></table></figure>

<h2 id="异常处理"><a href="#异常处理" class="headerlink" title="异常处理"></a>异常处理</h2><h3 id="try-catch-finally"><a href="#try-catch-finally" class="headerlink" title="try-catch-finally"></a>try-catch-finally</h3><p>该语句用于在指定错误发生时改变脚本的正常流程，可以有效的控制错误</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br><span class="line">19</span><br><span class="line">20</span><br><span class="line">21</span><br><span class="line">22</span><br><span class="line">23</span><br><span class="line">24</span><br><span class="line">25</span><br><span class="line">26</span><br><span class="line">27</span><br><span class="line">28</span><br><span class="line">29</span><br><span class="line">30</span><br><span class="line">31</span><br><span class="line">32</span><br><span class="line">33</span><br><span class="line">34</span><br><span class="line">35</span><br><span class="line">36</span><br><span class="line">37</span><br><span class="line">38</span><br><span class="line">39</span><br><span class="line">40</span><br><span class="line">41</span><br><span class="line">42</span><br><span class="line">43</span><br><span class="line">44</span><br><span class="line">45</span><br><span class="line">46</span><br><span class="line">47</span><br><span class="line">48</span><br><span class="line">49</span><br><span class="line">50</span><br><span class="line">51</span><br><span class="line">52</span><br></pre></td><td class="code"><pre><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">f1</span>(<span class="params"><span class="variable">$a</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="keyword">if</span> (<span class="variable">$a</span>) &#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="string">&quot;a&quot;</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="keyword">else</span></span><br><span class="line">	&#123;</span><br><span class="line">		<span class="comment">#抛出异常，第一个参数是异常信息，第二个参数为用户自定义异常编码，默认为0</span></span><br><span class="line">		<span class="keyword">throw</span> <span class="keyword">new</span> <span class="built_in">Exception</span>(<span class="string">&quot;a Error&quot;</span>, <span class="number">1</span>);</span><br><span class="line">	&#125;</span><br><span class="line">&#125;</span><br><span class="line"></span><br><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">f2</span>(<span class="params"><span class="variable">$b</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="keyword">if</span> (<span class="variable">$b</span>) &#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="string">&quot;b&quot;</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="keyword">else</span></span><br><span class="line">	&#123;</span><br><span class="line">		<span class="comment">#抛出异常</span></span><br><span class="line">		<span class="keyword">throw</span> <span class="keyword">new</span> <span class="built_in">Exception</span>(<span class="string">&quot;b Error&quot;</span>, <span class="number">2</span>);</span><br><span class="line">		</span><br><span class="line">	&#125;</span><br><span class="line">&#125;</span><br><span class="line"></span><br><span class="line"><span class="keyword">try</span>&#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;enter&quot;</span>;<span class="comment">//输出</span></span><br><span class="line">	<span class="title function_ invoke__">f1</span>(<span class="number">1</span>);<span class="comment">//a</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;stop&quot;</span>;<span class="comment">//输出</span></span><br><span class="line">	<span class="comment">#当异常被抛出后代码不会继续执行，PHP会尝试查找匹配的代码块</span></span><br><span class="line">	<span class="title function_ invoke__">f2</span>(<span class="number">0</span>);<span class="comment">//code:2 message:b Error line:26 file:F:\work\php_workspace\错误异常处理2.php</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;end&quot;</span>;</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment"># 捕获try中的潜在异常，可以使用多个catch块捕获多种异常</span></span><br><span class="line"><span class="keyword">catch</span>(<span class="built_in">Exception</span> <span class="variable">$e</span>)</span><br><span class="line">&#123;</span><br><span class="line">	<span class="comment">#捕获后的异常如果有能力处理，可以在此处处理</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;code:&quot;</span>.<span class="variable">$e</span>-&gt;<span class="title function_ invoke__">getCode</span>();</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;message:&quot;</span>.<span class="variable">$e</span>-&gt;<span class="title function_ invoke__">getMessage</span>();</span><br><span class="line">	<span class="comment">#异常抛出位置</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;line:&quot;</span>.<span class="variable">$e</span>-&gt;<span class="title function_ invoke__">getLine</span>();</span><br><span class="line">	<span class="comment">#异常抛出文件及路径</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;file:&quot;</span>.<span class="variable">$e</span>-&gt;<span class="title function_ invoke__">getFile</span>();</span><br><span class="line"></span><br><span class="line">	<span class="comment">#捕获后的异常也可以继续抛出，直到系统默认的顶级异常处理器处理</span></span><br><span class="line">	<span class="comment">#throw $e;//Fatal error: Uncaught Exception</span></span><br><span class="line">&#125;</span><br><span class="line"><span class="keyword">finally</span></span><br><span class="line">&#123;</span><br><span class="line">	<span class="comment">#异常处理完后执行代码</span></span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;finally codes&quot;</span>;<span class="comment">//最后输出</span></span><br><span class="line">&#125;</span><br></pre></td></tr></table></figure>

<h3 id="顶级异常处理器"><a href="#顶级异常处理器" class="headerlink" title="顶级异常处理器"></a>顶级异常处理器</h3><p>对于当前代码段抛出后未捕获的异常会继续向上抛出，直到被PHP默认的顶级异常处理器捕获，用户也可以自己定义自己的顶级异常处理器</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br><span class="line">19</span><br><span class="line">20</span><br><span class="line">21</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#自定义一个顶级异常处理器</span></span><br><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">my_exception</span>(<span class="params"><span class="variable">$e</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;我的顶级异常处理器&quot;</span>.<span class="variable">$e</span>-&gt;<span class="title function_ invoke__">getMessage</span>();</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#修改默认的顶级异常处理函数</span></span><br><span class="line"><span class="title function_ invoke__">set_exception_handler</span>(<span class="string">&quot;my_exception&quot;</span>);</span><br><span class="line"><span class="keyword">try</span> &#123;</span><br><span class="line">	<span class="comment">#f2(0);//我的顶级异常处理器b Error</span></span><br><span class="line">&#125; <span class="keyword">catch</span> (<span class="built_in">Exception</span> <span class="variable">$e</span>) &#123;</span><br><span class="line">	<span class="keyword">throw</span> <span class="variable">$e</span>;</span><br><span class="line">&#125; <span class="keyword">finally</span>&#123;</span><br><span class="line"></span><br><span class="line">&#125;</span><br><span class="line"></span><br><span class="line"><span class="keyword">try</span> &#123;</span><br><span class="line">	<span class="comment">#PHP不会自动抛出异常，错误代码会自动调用错误处理机制</span></span><br><span class="line">	<span class="variable">$a</span>=<span class="number">1</span>/<span class="number">0</span>;<span class="comment">//报错 Warning: Division by zero</span></span><br><span class="line">&#125; <span class="keyword">catch</span> (<span class="built_in">Exception</span> <span class="variable">$e</span>) &#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;err&quot;</span>;<span class="comment">//不输出</span></span><br><span class="line">&#125;</span><br></pre></td></tr></table></figure>

<hr />

    </div>

    
    
    
        <div class="reward-container">
  <div>坚持原创技术分享，您的支持将鼓励我继续创作！</div>
  <button onclick="var qr = document.getElementById('qr'); qr.style.display = (qr.style.display === 'none') ? 'block' : 'none';">
    打赏
  </button>
  <div id="qr" style="display: none;">
      
      <div style="display: inline-block;">
        <img src="https://shitsurei-pictures.oss-cn-beijing.aliyuncs.com/pics/wechatpay.jpg" alt="GuoRong Zhang 微信支付">
        <p>微信支付</p>
      </div>
      
      <div style="display: inline-block;">
        <img src="https://shitsurei-pictures.oss-cn-beijing.aliyuncs.com/pics/alipay.jpg" alt="GuoRong Zhang 支付宝">
        <p>支付宝</p>
      </div>

  </div>
</div>


      <footer class="post-footer">
          <div class="post-tags">
              <a href="/tags/%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86/" rel="tag"><i class="fa fa-tag"></i> 错误处理</a>
              <a href="/tags/%E5%BC%82%E5%B8%B8%E5%A4%84%E7%90%86/" rel="tag"><i class="fa fa-tag"></i> 异常处理</a>
          </div>

        


        
    <div class="post-nav">
      <div class="post-nav-item">
    <a href="/korea" rel="prev" title="韩国电影专题">
      <i class="fa fa-chevron-left"></i> 韩国电影专题
    </a></div>
      <div class="post-nav-item">
    <a href="/php5" rel="next" title="PHP面向对象学习笔记1">
      PHP面向对象学习笔记1 <i class="fa fa-chevron-right"></i>
    </a></div>
    </div>
      </footer>
    
  </article>
  
  
  



          </div>
          
    
  <div class="comments">
    <div id="lv-container" data-id="city" data-uid="MTAyMC80MDI4NC8xNjgxMQ=="></div>
  </div>
  

<script>
  window.addEventListener('tabs:register', () => {
    let { activeClass } = CONFIG.comments;
    if (CONFIG.comments.storage) {
      activeClass = localStorage.getItem('comments_active') || activeClass;
    }
    if (activeClass) {
      let activeTab = document.querySelector(`a[href="#comment-${activeClass}"]`);
      if (activeTab) {
        activeTab.click();
      }
    }
  });
  if (CONFIG.comments.storage) {
    window.addEventListener('tabs:click', event => {
      if (!event.target.matches('.tabs-comment .tab-content .tab-pane')) return;
      let commentClass = event.target.classList[1];
      localStorage.setItem('comments_active', commentClass);
    });
  }
</script>

        </div>
          
  
  <div class="toggle sidebar-toggle">
    <span class="toggle-line toggle-line-first"></span>
    <span class="toggle-line toggle-line-middle"></span>
    <span class="toggle-line toggle-line-last"></span>
  </div>

  <aside class="sidebar">
    <div class="sidebar-inner">

      <ul class="sidebar-nav motion-element">
        <li class="sidebar-nav-toc">
          文章目录
        </li>
        <li class="sidebar-nav-overview">
          站点概览
        </li>
      </ul>

      <!--noindex-->
      <div class="post-toc-wrap sidebar-panel">
          <div class="post-toc motion-element"><ol class="nav"><li class="nav-item nav-level-2"><a class="nav-link" href="#%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86"><span class="nav-number">1.</span> <span class="nav-text">错误处理</span></a><ol class="nav-child"><li class="nav-item nav-level-3"><a class="nav-link" href="#%E9%94%99%E8%AF%AF%E7%BA%A7%E5%88%AB"><span class="nav-number">1.1.</span> <span class="nav-text">错误级别</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E4%B8%89%E7%A7%8D%E9%94%99%E8%AF%AF%E5%A4%84%E7%90%86%E6%96%B9%E5%BC%8F"><span class="nav-number">1.2.</span> <span class="nav-text">三种错误处理方式</span></a></li></ol></li><li class="nav-item nav-level-2"><a class="nav-link" href="#%E5%BC%82%E5%B8%B8%E5%A4%84%E7%90%86"><span class="nav-number">2.</span> <span class="nav-text">异常处理</span></a><ol class="nav-child"><li class="nav-item nav-level-3"><a class="nav-link" href="#try-catch-finally"><span class="nav-number">2.1.</span> <span class="nav-text">try-catch-finally</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E9%A1%B6%E7%BA%A7%E5%BC%82%E5%B8%B8%E5%A4%84%E7%90%86%E5%99%A8"><span class="nav-number">2.2.</span> <span class="nav-text">顶级异常处理器</span></a></li></ol></li></ol></div>
      </div>
      <!--/noindex-->

      <div class="site-overview-wrap sidebar-panel">
        <div class="site-author motion-element" itemprop="author" itemscope itemtype="http://schema.org/Person">
    <a href="/">
      <img class="site-author-image" itemprop="image" alt="GuoRong Zhang"
        src="https://shitsurei-pictures.oss-cn-beijing.aliyuncs.com/pics/avatar.jpg">
    </a>
  <p class="site-author-name" itemprop="name">GuoRong Zhang</p>
  <div class="site-description" itemprop="description">个人博客小站</div>
</div>
<div class="site-state-wrap motion-element">
  <nav class="site-state">
      <div class="site-state-item site-state-posts">
          <a href="/archives/">
        
          <span class="site-state-item-count">36</span>
          <span class="site-state-item-name">日志</span>
        </a>
      </div>
      <div class="site-state-item site-state-categories">
            <a href="/categories/">
          
        <span class="site-state-item-count">9</span>
        <span class="site-state-item-name">分类</span></a>
      </div>
      <div class="site-state-item site-state-tags">
            <a href="/tags/">
          
        <span class="site-state-item-count">55</span>
        <span class="site-state-item-name">标签</span></a>
      </div>
  </nav>
</div>
  <div class="links-of-author motion-element">
      <span class="links-of-author-item">
        <a href="https://github.com/shitsurei" title="GitHub → https:&#x2F;&#x2F;github.com&#x2F;shitsurei" rel="noopener" target="_blank"><i class="fab fa-github fa-fw"></i>GitHub</a>
      </span>
      <span class="links-of-author-item">
        <a href="/lfgewj21345@163.com" title="E-Mail → lfgewj21345@163.com"><i class="fa fa-envelope fa-fw"></i>E-Mail</a>
      </span>
      <span class="links-of-author-item">
        <a href="http://www.zhihu.com/people/zhang-guo-rong-44-53" title="知乎 → http:&#x2F;&#x2F;www.zhihu.com&#x2F;people&#x2F;zhang-guo-rong-44-53" rel="noopener" target="_blank"><i class="fa fa-book fa-fw"></i>知乎</a>
      </span>
  </div>


  <div class="links-of-blogroll motion-element">
    <div class="links-of-blogroll-title"><i class="fa fa-link fa-fw"></i>
      推荐阅读
    </div>
    <ul class="links-of-blogroll-list">
        <li class="links-of-blogroll-item">
          <a href="http://www.alloyteam.com/nav/" title="http:&#x2F;&#x2F;www.alloyteam.com&#x2F;nav&#x2F;" rel="noopener" target="_blank">Web前端导航</a>
        </li>
        <li class="links-of-blogroll-item">
          <a href="http://www.chuangzaoshi.com/code" title="http:&#x2F;&#x2F;www.chuangzaoshi.com&#x2F;code" rel="noopener" target="_blank">创造狮导航</a>
        </li>
        <li class="links-of-blogroll-item">
          <a href="http://www.36zhen.com/t?id=3448" title="http:&#x2F;&#x2F;www.36zhen.com&#x2F;t?id&#x3D;3448" rel="noopener" target="_blank">前端书籍资料</a>
        </li>
        <li class="links-of-blogroll-item">
          <a href="http://e.xitu.io/" title="http:&#x2F;&#x2F;e.xitu.io&#x2F;" rel="noopener" target="_blank">掘金酱</a>
        </li>
        <li class="links-of-blogroll-item">
          <a href="https://www.v2ex.com/" title="https:&#x2F;&#x2F;www.v2ex.com&#x2F;" rel="noopener" target="_blank">V2EX</a>
        </li>
        <li class="links-of-blogroll-item">
          <a href="https://www.v2ex.com/" title="https:&#x2F;&#x2F;www.v2ex.com&#x2F;" rel="noopener" target="_blank">印记中文</a>
        </li>
    </ul>
  </div>

      </div>

    </div>
  </aside>
  <div id="sidebar-dimmer"></div>


      </div>
    </main>

    <footer class="footer">
      <div class="footer-inner">
        

        

<div class="copyright">
  
  &copy; 2018 – 
  <span itemprop="copyrightYear">2025</span>
  <span class="with-love">
    <i class="fa fa-heart"></i>
  </span>
  <span class="author" itemprop="copyrightHolder">GuoRong Zhang</span>
</div>

<div class="weixin-box">
  <div class="weixin-menu">
    <div class="weixin-hover">
      <div class="weixin-description">微信扫一扫加我</div>
    </div>
  </div>
</div>

        








      </div>
    </footer>
  </div>

  
  <script src="//cdn.jsdelivr.net/npm/animejs@3.1.0/lib/anime.min.js"></script>
  <script src="//cdn.jsdelivr.net/gh/next-theme/pjax@0/pjax.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@2.1.3/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.2.5/dist/jquery.fancybox.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/lozad@1/dist/lozad.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/velocity-animate@1.2.1/velocity.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/velocity-animate@1/velocity.ui.min.js"></script>

<script src="/js/utils.js"></script>

<script src="/js/motion.js"></script>


<script src="/js/schemes/muse.js"></script>


<script src="/js/next-boot.js"></script>

  <script>
var pjax = new Pjax({
  selectors: [
    'head title',
    '#page-configurations',
    '.content-wrap',
    '.post-toc-wrap',
    '.languages',
    '#pjax'
  ],
  switches: {
    '.post-toc-wrap': Pjax.switches.innerHTML
  },
  analytics: false,
  cacheBust: false,
  scrollTo : !CONFIG.bookmark.enable
});

document.addEventListener('pjax:success', () => {
  document.querySelectorAll('script[data-pjax], script#page-configurations, #pjax script').forEach(element => {
    var code = element.text || element.textContent || element.innerHTML || '';
    var parent = element.parentNode;
    parent.removeChild(element);
    var script = document.createElement('script');
    if (element.id) {
      script.id = element.id;
    }
    if (element.className) {
      script.className = element.className;
    }
    if (element.type) {
      script.type = element.type;
    }
    if (element.src) {
      script.src = element.src;
      // Force synchronous loading of peripheral JS.
      script.async = false;
    }
    if (element.dataset.pjax !== undefined) {
      script.dataset.pjax = '';
    }
    if (code !== '') {
      script.appendChild(document.createTextNode(code));
    }
    parent.appendChild(script);
  });
  NexT.boot.refresh();
  // Define Motion Sequence & Bootstrap Motion.
  if (CONFIG.motion.enable) {
    NexT.motion.integrator
      .init()
      .add(NexT.motion.middleWares.subMenu)
      .add(NexT.motion.middleWares.postList)
      .bootstrap();
  }
  NexT.utils.updateSidebarPosition();
});
</script>




  




  
<script src="/js/local-search.js"></script>













    <div id="pjax">
  

  

<script>
NexT.utils.loadComments(document.querySelector('#lv-container'), () => {
  window.livereOptions = {
    refer: location.pathname.replace(CONFIG.root, '').replace('index.html', '')
  };
  (function(d, s) {
    var j, e = d.getElementsByTagName(s)[0];
    if (typeof LivereTower === 'function') { return; }
    j = d.createElement(s);
    j.src = 'https://cdn-city.livere.com/js/embed.dist.js';
    j.async = true;
    e.parentNode.insertBefore(j, e);
  })(document, 'script');
});
</script>

    </div>
  <!-- 页面点击小红心 -->
  <script type="text/javascript" src="/js/love.js"></script>
  <!--崩溃欺骗-->
<script type="text/javascript" src="/js/cheat.js"></script>
<script src="/live2dw/lib/L2Dwidget.min.js?094cbace49a39548bed64abff5988b05"></script><script>L2Dwidget.init({"pluginRootPath":"live2dw/","pluginJsPath":"lib/","pluginModelPath":"assets/","tagMode":false,"debug":false,"model":{"jsonPath":"https://cdn.jsdelivr.net/npm/live2d-widget-model-wanko@1.0.5/assets/wanko.model.json"},"display":{"position":"right","width":200,"height":400},"mobile":{"show":false},"log":false});</script></body>
</html>
