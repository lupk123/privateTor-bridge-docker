私有tor网络--meek网桥
====================

meek 简介
--------

由于meek网桥的特点： 
    
    tor client -> meek client -> meek server -> tor server
而meek client -> meek server 使用的是domain fronting技术，这部分在搭建过程中出问题最多
    
    meek client -> Meek中继反射器 -> meek server
    
meek server 即 tor 网桥搭建
--------------------------

步骤在 https://trac.torproject.org/projects/tor/wiki/doc/meek#Howtorunameek-serverbridge 已经说得很清楚了，不再赘述，只说一下需要注意的问题

1. meek server是使用go编写的，需要对源码进行编译，故主机需要安装go语言环境，Ubuntu的话使用下面命令即可：  
     apt-get install golang-go     
2. 源码中goptlib依赖包的连接无法到达，可以从 https://github.com/Yawning/goptlib 获取该包，并将meek-server.go的import内容修改即可
3. 修改的配置文件在script文件夹中
4. 由于meek server需要用HTTPS进行传输内容，故需要生成证书，证书的生成在dockefile中可查看。

meek中继反射器搭建
-----------------

本部分网上可参考内容较少，自己摸索着来的，还是说点注意的问题吧

1. 由于我搭建的PHP的，故直接从docker hub中pull了个PHP环境，在上面基础上改进的。
2. 将meek源码中index.php拷贝到/var/www/html中，但是测试curl 或者 wget时一直出现502错误，后来发现是证书通不过认证的问题，无奈之下，在index.php中加
了两行代码，即在curl过程中不验证证书：

    ```
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);     
  	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
    ```
    
3. 本反射器也需要提供https服务，因此也需要生成证书

meek client搭建
-----------------

步骤在 https://trac.torproject.org/projects/tor/wiki/doc/meek

1. 源码编译过程中遇到的问题与server编译过程相同，故同上
2. 运行过程中在握手阶段显示bad certificate，一直出错，还是证书问题，最后发现即使本地信任了中继反射器的证书还是会报错，于是还是采用了最简单粗暴的方式，
改源码。。。 修改meek-client.go的部分内容如下：

    ```
    //tr := new(http.Transport)
      tr := &http.Transport{
      	 TLSClientConfig: &tls.Config{InsecureSkipVerify: true},
      }
    ```
    
同时import添加："crypto/tls"

最后，大部分内容应该都在Dockerfile和其他配置文件中
