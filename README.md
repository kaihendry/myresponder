# MyResponder

An opensource PHP project to help dispatch local **guards** in gated
communities by SMS to a **home owner**'s address.

There are three parties involved in this system:

1. Guard (also known as "first responder")
2. Home owner
3. Management

Management's task is to approve by "arming" who can raise alerts and who can receive them.

Other features:

- Every alert or incident recorded in a JSON file. Logging incidents gives you the metrics to improve!
- Optional ability to time track guards, providing the "clock out"

## Setup

`envfile` needs:

    HOST=myresponder.local
    M_USER=duroa
    M_PASS=SECRET
    M_EMAIL=verifyme@email.com
    TZ=Asia/Singapore
    # M_EMAIL must be verfied!
    AWS_ACCESS_KEY_ID=AKIAJPZG5CILK47K132
    AWS_SECRET_ACCESS_KEY=SECRET
    REGION=us-west-2 # for AWS SES

To simulate new .local addresses, you need to do something like:

    $ avahi-publish -a -R myresponder.local 192.168.1.25
    Established under name 'myresponder.local'
    $ avahi-publish -a -R m.myresponder.local 192.168.1.25
    Established under name 'm.myresponder.local'

## Series of videos explaining the development & demonstrating its use

- [Documentation](docs/index.md)
- <https://natalian.org/2015/11/29/Neighbourhood_watch_on_the_Web/>
- [MyResponder Youtube playlist](https://www.youtube.com/playlist?list=PLiKgVPlhUNuyKRfZayi0LLcq7i9l3yOtE)
