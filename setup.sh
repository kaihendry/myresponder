#!/bin/bash
mkdir -p data/{arm,g,h,smsreport}
sudo chmod -R g+s data/
sudo chmod -R g+w data/
sudo setfacl -R -m default:group:http:rwx data
curl 'http://momentjs.com/downloads/moment.min.js' > m/moment.min.js
