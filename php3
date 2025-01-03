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

  <meta name="description" content="PHP中的数组是一个非常有意思的数据结构，我们最常用的两种用于保存数据的结构是list和map，不论是链式存储还是顺序存储，不论是散列存储还是其他的二叉树存储，保存相同数据类型的集合与复杂数据类型内部结构的存储都是日常开发中最基本的需求。而在PHP中的数组可以看做是这两种数据结构的综合，弱类型语言的机制使得数组不再是单一数据类型的集合，我们既可以把数组当成一个map，用于保存键值对，又可以作为li">
<meta property="og:type" content="article">
<meta property="og:title" content="PHP学习笔记3">
<meta property="og:url" content="https://shitsurei.online/php3">
<meta property="og:site_name" content="shitsurei">
<meta property="og:description" content="PHP中的数组是一个非常有意思的数据结构，我们最常用的两种用于保存数据的结构是list和map，不论是链式存储还是顺序存储，不论是散列存储还是其他的二叉树存储，保存相同数据类型的集合与复杂数据类型内部结构的存储都是日常开发中最基本的需求。而在PHP中的数组可以看做是这两种数据结构的综合，弱类型语言的机制使得数组不再是单一数据类型的集合，我们既可以把数组当成一个map，用于保存键值对，又可以作为li">
<meta property="og:locale" content="zh_CN">
<meta property="article:published_time" content="2018-10-30T15:44:35.000Z">
<meta property="article:modified_time" content="2018-11-02T07:14:26.827Z">
<meta property="article:author" content="GuoRong Zhang">
<meta property="article:tag" content="数组">
<meta property="article:tag" content="内存模型">
<meta name="twitter:card" content="summary">

<link rel="canonical" href="https://shitsurei.online/php3">


<script id="page-configurations">
  // https://hexo.io/docs/variables.html
  CONFIG.page = {
    sidebar: "",
    isHome : false,
    isPost : true,
    lang   : 'zh-CN'
  };
</script>

  <title>PHP学习笔记3 | shitsurei</title>
  






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
    <link itemprop="mainEntityOfPage" href="https://shitsurei.online/php3">

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
          PHP学习笔记3
        </h1>

        <div class="post-meta">
            <span class="post-meta-item">
              <span class="post-meta-item-icon">
                <i class="far fa-calendar"></i>
              </span>
              <span class="post-meta-item-text">发表于</span>

              <time title="创建时间：2018-10-30 23:44:35" itemprop="dateCreated datePublished" datetime="2018-10-30T23:44:35+08:00">2018-10-30</time>
            </span>
              <span class="post-meta-item">
                <span class="post-meta-item-icon">
                  <i class="far fa-calendar-check"></i>
                </span>
                <span class="post-meta-item-text">更新于</span>
                <time title="修改时间：2018-11-02 15:14:26" itemprop="dateModified" datetime="2018-11-02T15:14:26+08:00">2018-11-02</time>
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

      
        <p>PHP中的数组是一个非常有意思的数据结构，我们最常用的两种用于保存数据的结构是list和map，不论是链式存储还是顺序存储，不论是散列存储还是其他的二叉树存储，保存相同数据类型的集合与复杂数据类型内部结构的存储都是日常开发中最基本的需求。而在PHP中的数组可以看做是这两种数据结构的综合，弱类型语言的机制使得数组不再是单一数据类型的集合，我们既可以把数组当成一个map，用于保存键值对，又可以作为list保存同类型元素。<br>其次，PHP是基于C语言编写的面向对象脚本语言，他的内存模型也类似于C，分为堆、栈、常量区等几个部分，在今后的面向对象学习中还需要更深的理解。</p>
<span id="more"></span>

<h2 id="数组"><a href="#数组" class="headerlink" title="数组"></a>数组</h2><h3 id="数组创建"><a href="#数组创建" class="headerlink" title="数组创建"></a>数组创建</h3><p>PHP的数组支持动态增长，跳跃赋值</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#PHP中的数组使用array()函数创建</span></span><br><span class="line"><span class="variable">$value</span>=<span class="number">1</span>;</span><br><span class="line"><span class="variable">$arrayName</span> = <span class="keyword">array</span>(<span class="string">&#x27;index&#x27;</span> =&gt; <span class="variable">$value</span>, );</span><br></pre></td></tr></table></figure>

<h3 id="数组分类"><a href="#数组分类" class="headerlink" title="数组分类"></a>数组分类</h3><ul>
<li>索引数组</li>
</ul>
<p>带有数字索引的数组，可采用自动分配(索引从0开始)或手动分配(不重复即可,重复时以后分配的为准)</p>
<ul>
<li>关联数组</li>
</ul>
<p>带有指定键的数组，任意分配给数组的指定键的数组，可在创建数组时直接分配或之后的赋值中再分配</p>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$arr1</span> = <span class="keyword">array</span>(<span class="string">&#x27;a&#x27;</span> =&gt; <span class="number">1</span>,<span class="string">&#x27;b&#x27;</span> =&gt; <span class="number">2</span>);</span><br><span class="line"><span class="variable">$arr1</span>[<span class="string">&#x27;c&#x27;</span>]=<span class="number">3</span>;</span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$arr1</span>);<span class="comment">//array(6) &#123; [&quot;a&quot;]=&gt; int(1) [&quot;b&quot;]=&gt; int(2) [&quot;c&quot;]=&gt; int(3) &#125;</span></span><br></pre></td></tr></table></figure>
<blockquote>
<p>缺省键值分配原则</p>
<ul>
<li>从首个元素遍历至当前元素，寻找是否有以数字作为键值的元素</li>
<li>如果没有，以0作为默认的缺省键值</li>
<li>如果有，将距离缺省元素最近的前一位符合1条件的元素的键值加1作为缺省元素的键值</li>
<li>如果之后的元素占用了当且缺省元素所分配的键值，遵循重复覆盖的原则</li>
</ul>
</blockquote>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$arr2</span> = <span class="keyword">array</span>(<span class="string">&#x27;3&#x27;</span> =&gt; <span class="number">1</span>,<span class="string">&#x27;8&#x27;</span> =&gt; <span class="number">2</span>,<span class="string">&#x27;a&#x27;</span> =&gt; <span class="number">3</span>,<span class="number">4</span>,<span class="string">&#x27;c&#x27;</span> =&gt; <span class="number">5</span>);</span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$arr2</span>);<span class="comment">//array(6) &#123; [3]=&gt; int(1) [8]=&gt; int(2) [&quot;a&quot;]=&gt; int(3) [9]=&gt; int(4) [&quot;c&quot;]=&gt; int(5) &#125;</span></span><br></pre></td></tr></table></figure>

<blockquote>
<p>非正常值作为键名</p>
<ol>
<li>使用true作为键名即使用1为键名，使用false作为键名即使用0作为键名</li>
<li>使用小数作为键名时，自动截断小数部分</li>
</ol>
</blockquote>
<ul>
<li>多维数组</li>
</ul>
<p>包含一个或多个数组的数组</p>
<h3 id="数组函数"><a href="#数组函数" class="headerlink" title="数组函数"></a>数组函数</h3><ul>
<li>获得数组的长度</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$arr2_len</span>=<span class="title function_ invoke__">count</span>(<span class="variable">$arr2</span>);</span><br><span class="line"><span class="keyword">echo</span> <span class="variable">$arr2_len</span>;<span class="comment">//5</span></span><br></pre></td></tr></table></figure>

<ul>
<li>判断数据类型是否为数组</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br></pre></td><td class="code"><pre><span class="line"><span class="keyword">echo</span> <span class="string">&quot;is_array&quot;</span>.<span class="title function_ invoke__">is_array</span>(<span class="variable">$arr2</span>);<span class="comment">//1</span></span><br></pre></td></tr></table></figure>

<ul>
<li>删除数组的任意个键值，但不会重建索引</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$arr3</span> = <span class="keyword">array</span>(<span class="string">&#x27;a&#x27;</span>,<span class="string">&#x27;b&#x27;</span>,<span class="string">&#x27;c&#x27;</span>,<span class="string">&#x27;d&#x27;</span>);</span><br><span class="line"><span class="keyword">unset</span>(<span class="variable">$arr3</span>[<span class="number">0</span>],<span class="variable">$arr3</span>[<span class="number">1</span>]);</span><br><span class="line"><span class="title function_ invoke__">print_r</span>(<span class="variable">$arr3</span>);<span class="comment">//Array ( [2] =&gt; c [3] =&gt; d ) </span></span><br></pre></td></tr></table></figure>

<ul>
<li>遍历数组</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br></pre></td><td class="code"><pre><span class="line"><span class="keyword">foreach</span> (<span class="variable">$arr1</span> <span class="keyword">as</span> <span class="variable">$key</span> =&gt; <span class="variable">$value</span>) &#123;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$key</span>=<span class="subst">$value</span>&quot;</span>;<span class="comment">//a=1b=2c=3</span></span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#for循环只能用于遍历索引数组</span></span><br><span class="line"><span class="keyword">for</span> (<span class="variable">$i</span>=<span class="number">0</span>; <span class="variable">$i</span> &lt; <span class="variable">$arr2_len</span>; <span class="variable">$i</span>++) &#123; </span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$arr2</span>[<span class="subst">$i</span>]&quot;</span>;<span class="comment">//遍历关联数组输出报错</span></span><br><span class="line">&#125;</span><br></pre></td></tr></table></figure>

<ul>
<li><p>数组排序</p>
</li>
<li><p>索引数组</p>
<ul>
<li>sort() - 以升序对数组排序</li>
<li>rsort() - 以降序对数组排序</li>
</ul>
</li>
<li><p>关联数组</p>
<ul>
<li>asort() - 根据值，以升序对关联数组进行排序</li>
<li>ksort() - 根据键，以升序对关联数组进行排序</li>
<li>arsort() - 根据值，以降序对关联数组进行排序</li>
<li>krsort() - 根据键，以降序对关联数组进行排序</li>
</ul>
</li>
<li><p>冒泡排序 - bubbleSort();</p>
</li>
<li><p>选择排序 - selectSort();</p>
</li>
<li><p>插入排序 - insertSort();</p>
</li>
</ul>
<h3 id="二维数组"><a href="#二维数组" class="headerlink" title="二维数组"></a>二维数组</h3><ul>
<li>定义</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#可采用直接定义或单个元素定义，每一行数组个数可以不同</span></span><br><span class="line"><span class="variable">$arr4</span> = <span class="keyword">array</span>(</span><br><span class="line"><span class="keyword">array</span>(<span class="string">&#x27;1&#x27;</span>,<span class="string">&#x27;2&#x27;</span>,<span class="string">&#x27;3&#x27;</span>,<span class="string">&#x27;4&#x27;</span>,<span class="string">&#x27;5&#x27;</span>),</span><br><span class="line"><span class="keyword">array</span>(<span class="string">&#x27;11&#x27;</span>,<span class="string">&#x27;21&#x27;</span>,<span class="string">&#x27;25&#x27;</span>),</span><br><span class="line"><span class="keyword">array</span>(<span class="string">&#x27;1&#x27;</span>,<span class="string">&#x27;2&#x27;</span>,<span class="string">&#x27;3&#x27;</span>,<span class="string">&#x27;4&#x27;</span>,<span class="string">&#x27;5&#x27;</span>),</span><br><span class="line"><span class="keyword">array</span>(<span class="string">&#x27;10&#x27;</span>)</span><br><span class="line">);</span><br><span class="line"><span class="comment">#等价于</span></span><br><span class="line"><span class="variable">$arr4</span>[<span class="number">0</span>] = <span class="keyword">array</span>(<span class="string">&#x27;1&#x27;</span>,<span class="string">&#x27;2&#x27;</span>,<span class="string">&#x27;3&#x27;</span>,<span class="string">&#x27;4&#x27;</span>,<span class="string">&#x27;5&#x27;</span>);</span><br><span class="line"><span class="variable">$arr4</span>[<span class="number">1</span>] = <span class="keyword">array</span>(<span class="string">&#x27;11&#x27;</span>,<span class="string">&#x27;21&#x27;</span>,<span class="string">&#x27;25&#x27;</span>);</span><br><span class="line"><span class="variable">$arr4</span>[<span class="number">2</span>] = <span class="keyword">array</span>(<span class="string">&#x27;1&#x27;</span>,<span class="string">&#x27;2&#x27;</span>,<span class="string">&#x27;3&#x27;</span>,<span class="string">&#x27;4&#x27;</span>,<span class="string">&#x27;5&#x27;</span>);</span><br><span class="line"><span class="variable">$arr4</span>[<span class="number">3</span>] = <span class="keyword">array</span>(<span class="string">&#x27;10&#x27;</span>);</span><br></pre></td></tr></table></figure>

<ul>
<li>遍历二维数组</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br></pre></td><td class="code"><pre><span class="line"><span class="keyword">for</span> (<span class="variable">$i</span>=<span class="number">0</span>; <span class="variable">$i</span> &lt; <span class="title function_ invoke__">count</span>(<span class="variable">$arr4</span>); <span class="variable">$i</span>++) &#123; </span><br><span class="line">	<span class="keyword">for</span> (<span class="variable">$j</span>=<span class="number">0</span>; <span class="variable">$j</span> &lt; <span class="title function_ invoke__">count</span>(<span class="variable">$arr4</span>[<span class="variable">$i</span>]); <span class="variable">$j</span>++) &#123; </span><br><span class="line">		<span class="keyword">echo</span> <span class="variable">$arr4</span>[<span class="variable">$i</span>][<span class="variable">$j</span>].<span class="string">&quot;&amp;nbsp;&quot;</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="keyword">echo</span> <span class="string">&quot;&lt;br/&gt;&quot;</span>;</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">/*输出</span></span><br><span class="line"><span class="comment">1 2 3 4 5 </span></span><br><span class="line"><span class="comment">11 21 25 </span></span><br><span class="line"><span class="comment">1 2 3 4 5 </span></span><br><span class="line"><span class="comment">10</span></span><br><span class="line"><span class="comment">*/</span></span><br></pre></td></tr></table></figure>


<h2 id="PHP内存模型"><a href="#PHP内存模型" class="headerlink" title="PHP内存模型"></a>PHP内存模型</h2><h3 id="栈区：存放基本数据类型"><a href="#栈区：存放基本数据类型" class="headerlink" title="栈区：存放基本数据类型"></a>栈区：存放基本数据类型</h3><figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#a和b都是存放在栈区不同地址空间的变量，其保存的值都为int型整数，a赋值给b时将0这一值赋给b的内存空间，因此对b的操作不会影响a的值</span></span><br><span class="line"><span class="variable">$a</span>=<span class="number">0</span>;</span><br><span class="line"><span class="variable">$b</span>=<span class="variable">$a</span>;</span><br><span class="line"><span class="variable">$b</span>++;</span><br><span class="line"><span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$a</span>/<span class="subst">$b</span>&quot;</span>;<span class="comment">//0/1</span></span><br><span class="line"><span class="comment">#当把a的地址赋给b之后，b的内存空间存放的即为a的地址，对b的操作实际上是对a地址的操作，即对a的值的操作</span></span><br><span class="line"><span class="variable">$b</span>=&amp;<span class="variable">$a</span>;</span><br><span class="line"><span class="variable">$b</span>++;</span><br><span class="line"><span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$a</span>/<span class="subst">$b</span>&quot;</span>;<span class="comment">//1/1</span></span><br></pre></td></tr></table></figure>

<h3 id="堆区：存放对象"><a href="#堆区：存放对象" class="headerlink" title="堆区：存放对象"></a>堆区：存放对象</h3><figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br></pre></td><td class="code"><pre><span class="line"><span class="class"><span class="keyword">class</span> <span class="title">Person</span></span></span><br><span class="line"><span class="class"></span>&#123;</span><br><span class="line">	<span class="keyword">public</span> <span class="variable">$name</span>;</span><br><span class="line">	<span class="keyword">public</span> <span class="variable">$age</span>;</span><br><span class="line">&#125;</span><br><span class="line"><span class="comment">#p1变量存放在栈中，p1对象存放在堆中</span></span><br><span class="line"><span class="variable">$p1</span>=<span class="keyword">new</span> <span class="title class_">Person</span>;</span><br><span class="line"><span class="comment">#p1通过地址引用访问堆中对象的成员变量</span></span><br><span class="line"><span class="variable">$p1</span>-&gt;name=<span class="string">&quot;Jack&quot;</span>;</span><br><span class="line"><span class="variable">$p1</span>-&gt;age=<span class="number">20</span>;</span><br><span class="line"><span class="comment">#调用函数时，栈区会开辟一片新栈，存放p变量，p和p1分别位于栈区不同的地址空间，但是其中保存的值相同，都指向堆中p1对象</span></span><br><span class="line"><span class="function"><span class="keyword">function</span> <span class="title">change_name</span>(<span class="params"><span class="variable">$p</span></span>)</span></span><br><span class="line"><span class="function"></span>&#123;</span><br><span class="line">	<span class="variable">$p</span>-&gt;name=<span class="string">&quot;Tom&quot;</span>;</span><br><span class="line">&#125;</span><br><span class="line"><span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$p1</span>-&gt;name&quot;</span>;<span class="comment">//Jack</span></span><br><span class="line"><span class="title function_ invoke__">change_name</span>(<span class="variable">$p1</span>);</span><br><span class="line"><span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$p1</span>-&gt;name&quot;</span>;<span class="comment">//Tom</span></span><br></pre></td></tr></table></figure>

<h3 id="全局区（静态数据区）"><a href="#全局区（静态数据区）" class="headerlink" title="全局区（静态数据区）"></a>全局区（静态数据区）</h3><ul>
<li>存放global关键字修饰的全局变量，全局变量在所有的栈中都可以访问</li>
<li>存放static关键字修饰的成员变量，一次创建，不随着对象的销毁而销毁</li>
</ul>
<h3 id="常量区：存放常量"><a href="#常量区：存放常量" class="headerlink" title="常量区：存放常量"></a>常量区：存放常量</h3><ul>
<li>存放常量，const关键字修饰的常量，声明时就要赋初值</li>
</ul>
<h3 id="代码区：存放指令"><a href="#代码区：存放指令" class="headerlink" title="代码区：存放指令"></a>代码区：存放指令</h3><hr />

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
              <a href="/tags/%E6%95%B0%E7%BB%84/" rel="tag"><i class="fa fa-tag"></i> 数组</a>
              <a href="/tags/%E5%86%85%E5%AD%98%E6%A8%A1%E5%9E%8B/" rel="tag"><i class="fa fa-tag"></i> 内存模型</a>
          </div>

        


        
    <div class="post-nav">
      <div class="post-nav-item">
    <a href="/japanese2" rel="prev" title="日语数字表达">
      <i class="fa fa-chevron-left"></i> 日语数字表达
    </a></div>
      <div class="post-nav-item">
    <a href="/korea" rel="next" title="韩国电影专题">
      韩国电影专题 <i class="fa fa-chevron-right"></i>
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
          <div class="post-toc motion-element"><ol class="nav"><li class="nav-item nav-level-2"><a class="nav-link" href="#%E6%95%B0%E7%BB%84"><span class="nav-number">1.</span> <span class="nav-text">数组</span></a><ol class="nav-child"><li class="nav-item nav-level-3"><a class="nav-link" href="#%E6%95%B0%E7%BB%84%E5%88%9B%E5%BB%BA"><span class="nav-number">1.1.</span> <span class="nav-text">数组创建</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E6%95%B0%E7%BB%84%E5%88%86%E7%B1%BB"><span class="nav-number">1.2.</span> <span class="nav-text">数组分类</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E6%95%B0%E7%BB%84%E5%87%BD%E6%95%B0"><span class="nav-number">1.3.</span> <span class="nav-text">数组函数</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E4%BA%8C%E7%BB%B4%E6%95%B0%E7%BB%84"><span class="nav-number">1.4.</span> <span class="nav-text">二维数组</span></a></li></ol></li><li class="nav-item nav-level-2"><a class="nav-link" href="#PHP%E5%86%85%E5%AD%98%E6%A8%A1%E5%9E%8B"><span class="nav-number">2.</span> <span class="nav-text">PHP内存模型</span></a><ol class="nav-child"><li class="nav-item nav-level-3"><a class="nav-link" href="#%E6%A0%88%E5%8C%BA%EF%BC%9A%E5%AD%98%E6%94%BE%E5%9F%BA%E6%9C%AC%E6%95%B0%E6%8D%AE%E7%B1%BB%E5%9E%8B"><span class="nav-number">2.1.</span> <span class="nav-text">栈区：存放基本数据类型</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E5%A0%86%E5%8C%BA%EF%BC%9A%E5%AD%98%E6%94%BE%E5%AF%B9%E8%B1%A1"><span class="nav-number">2.2.</span> <span class="nav-text">堆区：存放对象</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E5%85%A8%E5%B1%80%E5%8C%BA%EF%BC%88%E9%9D%99%E6%80%81%E6%95%B0%E6%8D%AE%E5%8C%BA%EF%BC%89"><span class="nav-number">2.3.</span> <span class="nav-text">全局区（静态数据区）</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E5%B8%B8%E9%87%8F%E5%8C%BA%EF%BC%9A%E5%AD%98%E6%94%BE%E5%B8%B8%E9%87%8F"><span class="nav-number">2.4.</span> <span class="nav-text">常量区：存放常量</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E4%BB%A3%E7%A0%81%E5%8C%BA%EF%BC%9A%E5%AD%98%E6%94%BE%E6%8C%87%E4%BB%A4"><span class="nav-number">2.5.</span> <span class="nav-text">代码区：存放指令</span></a></li></ol></li></ol></div>
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
