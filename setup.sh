#!/bin/bash
mkdir -p {g,h,m}/l # for logs
sudo chown -R $USER:apache .
sudo chmod -R g+rw .
# http://dabase.com/e/01178/
sudo chmod g+s .
sudo setfacl -R -m default:group:apache:rwx .
