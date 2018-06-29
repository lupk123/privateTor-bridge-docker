私有tor网络--obfs4网桥
=====================

obfs4搭建
----------

主要基于 https://hub.docker.com/r/vimagick/tor/ 中obfs4搭建的

obfs4搭建过程相对于meek简单许多，需要注意的问题也不多，最重要的一个问题：需要先运行一遍obfs4网桥，将fingerprint记录下来，在修改obfs4客户端内容
最后运行即可

主要内容和配置在dockerfile及相关配置文件中查看
