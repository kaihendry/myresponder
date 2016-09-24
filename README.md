# MyResponder

An opensource PHP project to help dispatch local **guards** in gated
communities by SMS to a **home owner**'s address.

There are three parties involved in this system:

1. Guard (also known as "first responder")
2. Home owner
3. Management

Management's task is to approve by "arming" who can raise alerts and who can receive them.

Other features:

* Every alert or incident is recorded in one JSON file. Logging incidents gives you the metrics to improve!
* Optional ability to time track guards, providing the "clock out"

## Setup

`envfile` needs to be populated:

	HOST=myresponder.local
	M_USER=duroa
	M_PASS=SECRET
	M_EMAIL=verifyme@email.com
	SMS_URL=https://rest.nexmo.com/sms/json?api_key=6bfec75d&api_secret=SECRET
	TZ=Asia/Singapore
	# M_EMAIL needs to be verfied!
	AWS_ACCESS_KEY_ID=AKIAJPZG5CILK47K132
	AWS_SECRET_ACCESS_KEY=SECRET
	REGION=us-west-2

Then you need to link to the container and do a transparent proxy like so:

	myresponder.local:80 {
		tls off
		proxy / myresponder:80 {
			transparent
		}
		log stdout
		errors stdout
	}
	d.myresponder.local:80 {
		tls off
		proxy / myresponder:80 {
			transparent
		}
		log stdout
		errors stdout
	}
	m.myresponder.local:80 {
		tls off
		proxy / myresponder:80 {
			transparent
		}
		log stdout
		errors stdout
	}
	g.myresponder.local:80 {
		tls off
		proxy / myresponder:80 {
			transparent
		}
		log stdout
		errors stdout
	}
	h.myresponder.local:80 {
		tls off
		proxy / myresponder:80 {
			transparent
		}
		log stdout
		errors stdout
	}

To simulate new .local addresses, you need to do something like:

	$ avahi-publish -a -R myresponder.local 192.168.1.25
	Established under name 'myresponder.local'
	$ avahi-publish -a -R m.myresponder.local 192.168.1.25
	Established under name 'm.myresponder.local'

## Series of videos explaining the development & demonstrating its use

* [Documentation](docs/index.md)
* <https://natalian.org/2015/11/29/Neighbourhood_watch_on_the_Web/>
* [MyResponder Youtube playlist](https://www.youtube.com/playlist?list=PLiKgVPlhUNuyKRfZayi0LLcq7i9l3yOtE)
