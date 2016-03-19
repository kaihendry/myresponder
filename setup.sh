#!/bin/bash
mkdir -p data/{arm,r,g,h,smsreport}
chmod -R g+s data/
chmod -R g+w data/
setfacl -R -m default:group:http:rwx data
curl 'http://momentjs.com/downloads/moment.min.js' > m/moment.min.js
curl 'http://cdn.ractivejs.org/latest/ractive.min.js' > h/ractive.min.js
