Getting started for Docker Engine CE (Free Version)
---------------------------------------------------

```
sudo mkdir -p build && cd build

sudo apt-get install git -y

sudo git clone https://github.com/drivesoft-technology/docker-awesome.git

cd docker-awesome
```


Install Docker Engine CE v18.06.1 (Free Version)
---------------------------------------------------

```
bash docker-install/install-docker-engine-on-ubuntu18.sh
```


Install Docker Compose v1.22.0
---------------------------------------------------

```
bash docker-install/install-docker-compose-on-ubuntu18.sh
```


Start Service | Phalcon Application Template
---------------------------------------------------

```
sudo git clone https://github.com/codestepz/phalcon3-share-template.git
sudo docker-compose -f phalcon3-share-template/example.com-deploy/docker-compose.yml up -d
chmod 0777 -R phalcon3-share-template/example.com-main/runtime
```

```
http://[IP ADDRESS] << Nginx v1.15.4-alpine

http://[IP ADDRESS]/info.php << PHP v7.2.10 (FPM) 
```
