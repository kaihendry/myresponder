#!/bin/bash
mkdir -p {g,h,m}/l # for logs
mkdir {g,h}/muted # directory to record if they are part of the alert
sudo chown -R $USER:apache .
sudo chmod -R g+rw .
# http://dabase.com/e/01178/
sudo chmod g+s .
sudo setfacl -R -m default:group:apache:rwx .
