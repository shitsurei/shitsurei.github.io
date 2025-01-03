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

  <meta name="description" content="编程语言在发展过程中大致经历了三个阶段，早期开发面临的情况是简单重复的科学计算，机械笨重的硬件平台，因此编程语言要尽可能的贴近底层，便于开发。随着软硬件技术水平的进步，编程语言也取得了长足的发展，从最初面向机器的汇编语言，到后来面向过程的C语言（封装函数，便于功能的复用），再到现在面向对象的java、PHP（封装对象，便于组建的复用），编程语言越来越接近自然语言和自然人的思维方式，这一改变大大降低">
<meta property="og:type" content="article">
<meta property="og:title" content="PHP面向对象学习笔记1">
<meta property="og:url" content="https://shitsurei.online/php5">
<meta property="og:site_name" content="shitsurei">
<meta property="og:description" content="编程语言在发展过程中大致经历了三个阶段，早期开发面临的情况是简单重复的科学计算，机械笨重的硬件平台，因此编程语言要尽可能的贴近底层，便于开发。随着软硬件技术水平的进步，编程语言也取得了长足的发展，从最初面向机器的汇编语言，到后来面向过程的C语言（封装函数，便于功能的复用），再到现在面向对象的java、PHP（封装对象，便于组建的复用），编程语言越来越接近自然语言和自然人的思维方式，这一改变大大降低">
<meta property="og:locale" content="zh_CN">
<meta property="article:published_time" content="2018-11-03T15:04:44.000Z">
<meta property="article:modified_time" content="2018-11-05T10:34:23.176Z">
<meta property="article:author" content="GuoRong Zhang">
<meta property="article:tag" content="对象">
<meta property="article:tag" content="类">
<meta property="article:tag" content="静态方法">
<meta property="article:tag" content="静态变量">
<meta name="twitter:card" content="summary">

<link rel="canonical" href="https://shitsurei.online/php5">


<script id="page-configurations">
  // https://hexo.io/docs/variables.html
  CONFIG.page = {
    sidebar: "",
    isHome : false,
    isPost : true,
    lang   : 'zh-CN'
  };
</script>

  <title>PHP面向对象学习笔记1 | shitsurei</title>
  






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
    <link itemprop="mainEntityOfPage" href="https://shitsurei.online/php5">

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
          PHP面向对象学习笔记1
        </h1>

        <div class="post-meta">
            <span class="post-meta-item">
              <span class="post-meta-item-icon">
                <i class="far fa-calendar"></i>
              </span>
              <span class="post-meta-item-text">发表于</span>

              <time title="创建时间：2018-11-03 23:04:44" itemprop="dateCreated datePublished" datetime="2018-11-03T23:04:44+08:00">2018-11-03</time>
            </span>
              <span class="post-meta-item">
                <span class="post-meta-item-icon">
                  <i class="far fa-calendar-check"></i>
                </span>
                <span class="post-meta-item-text">更新于</span>
                <time title="修改时间：2018-11-05 18:34:23" itemprop="dateModified" datetime="2018-11-05T18:34:23+08:00">2018-11-05</time>
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

      
        <p>编程语言在发展过程中大致经历了三个阶段，早期开发面临的情况是简单重复的科学计算，机械笨重的硬件平台，因此编程语言要尽可能的贴近底层，便于开发。随着软硬件技术水平的进步，编程语言也取得了长足的发展，从最初面向机器的汇编语言，到后来面向过程的C语言（封装函数，便于功能的复用），再到现在面向对象的java、PHP（封装对象，便于组建的复用），编程语言越来越接近自然语言和自然人的思维方式，这一改变大大降低了编程语言学习的门槛。可以展望，在不远的未来，我们很有可能用自然语言去编写程序，正是这样一层一层的封装，把内部结构包裹起来，只暴露外部接口，将我们的开发过程和底层隔离开，因此抽象和封装是现代编程语言最重要的特点，也是现代社会运行分工协作的方式。</p>
<span id="more"></span>

<h2 id="类和对象"><a href="#类和对象" class="headerlink" title="类和对象"></a>类和对象</h2><div class="note info"><p>请将本标题下的所有代码段链接起来学习理解。</p></div>

<h3 id="类的创建"><a href="#类的创建" class="headerlink" title="类的创建"></a>类的创建</h3><ul>
<li>成员属性，可以是基本数据类型或符合数据类型</li>
<li>构造方法，默认的访问修饰符是<strong>public</strong></li>
<li>析构方法，主要作用是释放资源，例如数据库连接，图片资源等，并非销毁对象本身（即无默认的析构方法）</li>
<li>成员方法，默认的访问修饰符是<strong>public</strong></li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br><span class="line">19</span><br><span class="line">20</span><br><span class="line">21</span><br><span class="line">22</span><br><span class="line">23</span><br><span class="line">24</span><br><span class="line">25</span><br><span class="line">26</span><br></pre></td><td class="code"><pre><span class="line"><span class="class"><span class="keyword">class</span> <span class="title">Animal</span> </span></span><br><span class="line"><span class="class"></span>&#123;</span><br><span class="line">	<span class="comment">#成员属性</span></span><br><span class="line">	<span class="keyword">public</span> <span class="variable">$kind</span>;</span><br><span class="line">	<span class="keyword">public</span> <span class="variable">$number</span>;</span><br><span class="line">	<span class="comment">#构造方法</span></span><br><span class="line">	<span class="keyword">public</span> <span class="function"><span class="keyword">function</span> <span class="title">__construct</span>(<span class="params"><span class="variable">$kind</span>,<span class="variable">$number</span></span>)</span>&#123;</span><br><span class="line">		<span class="comment">#this代表当前对象,实质上是对当前对象的引用,只能在构造方法中使用</span></span><br><span class="line">		<span class="comment">#创建对象时默认先调用对象的构造方法,假设没定义,系统默认提供空构造方法,this会通过对象变量名所保存的地址去堆区的对象出做初始化操作</span></span><br><span class="line">		<span class="variable language_">$this</span>-&gt;kind=<span class="variable">$kind</span>;</span><br><span class="line">		<span class="variable language_">$this</span>-&gt;number=<span class="variable">$number</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="comment">#析构方法</span></span><br><span class="line">	<span class="comment">#一个类只有一个析构函数，且该方法不能传递参数</span></span><br><span class="line">	<span class="comment">#程序退出（进程结束）或该对象成为垃圾对象（一个对象没有任何引用指向他）时自动调用，同一类的不同对象的调用顺序是先创建的对象后被销毁（栈的FILO机制）</span></span><br><span class="line">	<span class="function"><span class="keyword">function</span> <span class="title">__destruct</span>(<span class="params"></span>)</span>&#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="string">&quot;<span class="subst">$this</span>-&gt;kind被销毁&quot;</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="comment">#成员方法</span></span><br><span class="line">	<span class="keyword">public</span> <span class="function"><span class="keyword">function</span> <span class="title">walk</span>(<span class="params"></span>)</span>&#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="string">&quot;walking&quot;</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="keyword">public</span> <span class="function"><span class="keyword">function</span> <span class="title">eat</span>(<span class="params"><span class="variable">$food</span></span>)</span>&#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="string">&quot;eating&quot;</span>.<span class="variable">$food</span>;</span><br><span class="line">	&#125;</span><br><span class="line">&#125;</span><br></pre></td></tr></table></figure>

<h3 id="对象的创建"><a href="#对象的创建" class="headerlink" title="对象的创建"></a>对象的创建</h3><figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br></pre></td><td class="code"><pre><span class="line"><span class="comment">#对象的基本创建（实例化），后面括号可选 new</span></span><br><span class="line"><span class="variable">$cat</span>=<span class="keyword">new</span> <span class="title class_">Animal</span>(<span class="string">&quot;未定义&quot;</span>,<span class="number">0</span>);<span class="comment">//construct method</span></span><br><span class="line"><span class="variable">$dog</span>=<span class="keyword">new</span> <span class="title class_">Animal</span>(<span class="string">&quot;未定义&quot;</span>,<span class="number">0</span>);<span class="comment">//construct method</span></span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$cat</span>);<span class="comment">//object(Animal)#2 (2) &#123; [&quot;kind&quot;]=&gt; string(9) &quot;未定义&quot; [&quot;number&quot;]=&gt; int(0) &#125;</span></span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$dog</span>);<span class="comment">//object(Animal)#2 (2) &#123; [&quot;kind&quot;]=&gt; string(9) &quot;未定义&quot; [&quot;number&quot;]=&gt; int(0) &#125;</span></span><br></pre></td></tr></table></figure>

<h3 id="访问对象"><a href="#访问对象" class="headerlink" title="访问对象"></a>访问对象</h3><ul>
<li>访问对象的属性 <strong>-&gt;</strong></li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$cat</span>-&gt;kind=<span class="string">&quot;猫科&quot;</span>;</span><br><span class="line"><span class="variable">$cat</span>-&gt;number=<span class="number">2</span>;</span><br><span class="line"><span class="variable">$dog</span>-&gt;kind=<span class="string">&quot;犬科&quot;</span>;</span><br><span class="line"><span class="variable">$dog</span>-&gt;number=<span class="number">3</span>;</span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$cat</span>);<span class="comment">//object(Animal)#1 (2) &#123; [&quot;kind&quot;]=&gt; string(6) &quot;猫科&quot; [&quot;number&quot;]=&gt; int(2) &#125;</span></span><br><span class="line"><span class="title function_ invoke__">var_dump</span>(<span class="variable">$dog</span>);<span class="comment">//object(Animal)#1 (2) &#123; [&quot;kind&quot;]=&gt; string(6) &quot;猫科&quot; [&quot;number&quot;]=&gt; int(2) &#125;</span></span><br></pre></td></tr></table></figure>

<ul>
<li>访问对象的方法 <strong>-&gt;</strong></li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$cat</span>-&gt;<span class="title function_ invoke__">walk</span>();<span class="comment">//walking</span></span><br><span class="line"><span class="variable">$cat</span>-&gt;<span class="title function_ invoke__">eat</span>(<span class="string">&quot; meat&quot;</span>);<span class="comment">//eating meat</span></span><br></pre></td></tr></table></figure>

<blockquote>
<p><strong>对象的内存模型</strong><br>对象创建时在栈中存放变量名同时在堆中开辟空间用于存放真正的对象，变量名保存的是指向堆中对象位置的地址，因此PHP当中对象是按引用传递的，每个对象的变量都持有对象的引用，而非对象的拷贝</p>
</blockquote>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br></pre></td><td class="code"><pre><span class="line"><span class="variable">$tiger</span>=<span class="variable">$cat</span>;</span><br><span class="line"><span class="keyword">echo</span> <span class="variable">$tiger</span>-&gt;kind;<span class="comment">//猫科</span></span><br></pre></td></tr></table></figure>

<h2 id="静态变量和静态方法"><a href="#静态变量和静态方法" class="headerlink" title="静态变量和静态方法"></a>静态变量和静态方法</h2><ul>
<li>静态变量 <strong>static</strong> 与其相对的成为实例变量，同一个类的所有对象都共享的变量</li>
<li>类外部可以直接用类名访问静态变量，意味着静态变量不依赖于对象而存在</li>
<li>静态方法（类方法） <strong>static</strong> 不能访问非静态属性，普通成员方法可以访问静态变量和非静态变量</li>
<li>类外部可以直接用类名访问静态方法，意味着静态变量不依赖于对象而存在</li>
</ul>
<figure class="highlight php"><table><tr><td class="gutter"><pre><span class="line">1</span><br><span class="line">2</span><br><span class="line">3</span><br><span class="line">4</span><br><span class="line">5</span><br><span class="line">6</span><br><span class="line">7</span><br><span class="line">8</span><br><span class="line">9</span><br><span class="line">10</span><br><span class="line">11</span><br><span class="line">12</span><br><span class="line">13</span><br><span class="line">14</span><br><span class="line">15</span><br><span class="line">16</span><br><span class="line">17</span><br><span class="line">18</span><br><span class="line">19</span><br><span class="line">20</span><br><span class="line">21</span><br><span class="line">22</span><br><span class="line">23</span><br><span class="line">24</span><br><span class="line">25</span><br><span class="line">26</span><br><span class="line">27</span><br><span class="line">28</span><br><span class="line">29</span><br><span class="line">30</span><br><span class="line">31</span><br><span class="line">32</span><br><span class="line">33</span><br><span class="line">34</span><br><span class="line">35</span><br><span class="line">36</span><br><span class="line">37</span><br><span class="line">38</span><br></pre></td><td class="code"><pre><span class="line"><span class="class"><span class="keyword">class</span> <span class="title">People</span></span></span><br><span class="line"><span class="class"></span>&#123;</span><br><span class="line">	<span class="keyword">public</span> <span class="variable">$name</span>;</span><br><span class="line">	<span class="comment">#定义并初始化一个静态变量，定义位置在常量区</span></span><br><span class="line">	<span class="keyword">public</span> <span class="built_in">static</span> <span class="variable">$num</span> = <span class="number">0</span>;</span><br><span class="line">	<span class="function"><span class="keyword">function</span> <span class="title">__construct</span>(<span class="params"><span class="variable">$name</span></span>)</span></span><br><span class="line"><span class="function">	</span>&#123;</span><br><span class="line">		<span class="variable language_">$this</span>-&gt;name=<span class="variable">$name</span>;</span><br><span class="line">		<span class="variable language_">$this</span>-&gt;num=<span class="number">20</span>;<span class="comment">//访问方式错误，但是不创建对象不会报错，说明PHP是运行时才执行的语言</span></span><br><span class="line">	&#125;</span><br><span class="line">	<span class="comment">#定义一个静态方法</span></span><br><span class="line">	<span class="built_in">static</span> <span class="function"><span class="keyword">function</span> <span class="title">get_num</span>(<span class="params"></span>)</span></span><br><span class="line"><span class="function">	</span>&#123;</span><br><span class="line">		<span class="keyword">echo</span> <span class="built_in">self</span>::<span class="variable">$num</span>;</span><br><span class="line">	&#125;</span><br><span class="line">	<span class="function"><span class="keyword">function</span> <span class="title">add</span>(<span class="params"></span>)</span></span><br><span class="line"><span class="function">	</span>&#123;</span><br><span class="line">		<span class="comment">#类内部访问静态变量，两种访问方式</span></span><br><span class="line">		<span class="title class_">People</span>::<span class="variable">$num</span>++;</span><br><span class="line">		<span class="built_in">self</span>::<span class="variable">$num</span>++;</span><br><span class="line"></span><br><span class="line">		<span class="keyword">echo</span> <span class="variable language_">$this</span>-&gt;name.<span class="string">&quot;加入&quot;</span>;</span><br><span class="line"></span><br><span class="line">		<span class="comment">#类内部访问静态方法</span></span><br><span class="line">		<span class="built_in">self</span>::<span class="title function_ invoke__">get_num</span>();<span class="comment">//2</span></span><br><span class="line">		<span class="title class_">People</span>::<span class="title function_ invoke__">get_num</span>();<span class="comment">//2</span></span><br><span class="line">	&#125;</span><br><span class="line">&#125;</span><br><span class="line"><span class="variable">$p1</span> = <span class="keyword">new</span> <span class="title class_">People</span>(<span class="string">&quot;Tom&quot;</span>);</span><br><span class="line"><span class="variable">$p1</span>-&gt;<span class="title function_ invoke__">add</span>();<span class="comment">//22</span></span><br><span class="line"></span><br><span class="line"><span class="comment">#类外部访问静态变量</span></span><br><span class="line"><span class="keyword">echo</span> <span class="title class_">People</span>::<span class="variable">$num</span>;<span class="comment">//2</span></span><br><span class="line"></span><br><span class="line"><span class="comment">#类外部访问静态方法</span></span><br><span class="line"><span class="variable">$p1</span>-&gt;<span class="title function_ invoke__">get_num</span>();<span class="comment">//6</span></span><br><span class="line"><span class="comment">#直接用类名访问静态方法，意味着静态变量不依赖于对象而存在</span></span><br><span class="line"><span class="title class_">People</span>::<span class="title function_ invoke__">get_num</span>();<span class="comment">//6</span></span><br></pre></td></tr></table></figure>

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
              <a href="/tags/%E5%AF%B9%E8%B1%A1/" rel="tag"><i class="fa fa-tag"></i> 对象</a>
              <a href="/tags/%E7%B1%BB/" rel="tag"><i class="fa fa-tag"></i> 类</a>
              <a href="/tags/%E9%9D%99%E6%80%81%E6%96%B9%E6%B3%95/" rel="tag"><i class="fa fa-tag"></i> 静态方法</a>
              <a href="/tags/%E9%9D%99%E6%80%81%E5%8F%98%E9%87%8F/" rel="tag"><i class="fa fa-tag"></i> 静态变量</a>
          </div>

        


        
    <div class="post-nav">
      <div class="post-nav-item">
    <a href="/php4" rel="prev" title="PHP学习笔记4">
      <i class="fa fa-chevron-left"></i> PHP学习笔记4
    </a></div>
      <div class="post-nav-item">
    <a href="/php6" rel="next" title="PHP面向对象学习笔记2">
      PHP面向对象学习笔记2 <i class="fa fa-chevron-right"></i>
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
          <div class="post-toc motion-element"><ol class="nav"><li class="nav-item nav-level-2"><a class="nav-link" href="#%E7%B1%BB%E5%92%8C%E5%AF%B9%E8%B1%A1"><span class="nav-number">1.</span> <span class="nav-text">类和对象</span></a><ol class="nav-child"><li class="nav-item nav-level-3"><a class="nav-link" href="#%E7%B1%BB%E7%9A%84%E5%88%9B%E5%BB%BA"><span class="nav-number">1.1.</span> <span class="nav-text">类的创建</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E5%AF%B9%E8%B1%A1%E7%9A%84%E5%88%9B%E5%BB%BA"><span class="nav-number">1.2.</span> <span class="nav-text">对象的创建</span></a></li><li class="nav-item nav-level-3"><a class="nav-link" href="#%E8%AE%BF%E9%97%AE%E5%AF%B9%E8%B1%A1"><span class="nav-number">1.3.</span> <span class="nav-text">访问对象</span></a></li></ol></li><li class="nav-item nav-level-2"><a class="nav-link" href="#%E9%9D%99%E6%80%81%E5%8F%98%E9%87%8F%E5%92%8C%E9%9D%99%E6%80%81%E6%96%B9%E6%B3%95"><span class="nav-number">2.</span> <span class="nav-text">静态变量和静态方法</span></a></li></ol></div>
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
