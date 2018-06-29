# privateTor--bridge

由于工作要求，需要在内网基于meek和obfs4搭建了两种私有tor网络

本环境实在 https://github.com/antitree/private-tor-network 基础上添加了网桥的功能

主要有以下几个部分的改动：

1. 由于测试过程中需要对容器和镜像不断的修改，随机IP分配相对比较繁琐，故给每一个容器分配了具体的IP，因为需要测试的节点不需要很多，固定IP相对随机IP更为简单
2. 在script的docker-entrypoint文件中加入了meek和obfs4两个网桥的配置

运行： docker compose up

浏览器设置代理：socks 5 9050

全局代理设置： proxychain4 software start -i 

proxychain4安装： https://blog.fazero.me/2015/08/31/%E5%88%A9%E7%94%A8proxychains%E5%9C%A8%E7%BB%88%E7%AB%AF%E4%BD%BF%E7%94%A8socks5%E4%BB%A3%E7%90%86/

