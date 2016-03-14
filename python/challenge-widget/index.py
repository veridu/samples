#!/usr/bin/env python

from time import sleep

# importing SDK modules
from Veridu.SDK.API import API
from Veridu.SDK.Session import Session

# importing client configuration
from settings import VeriduSettings

# Unique username assigned by your system
# more info: https://veridu.com/wiki/User_ID
username = "unique-user-id";

# API and Session SDK instantiation
# more info: https://github.com/veridu/veridu-python
api = API(key=VeriduSettings["key"], secret=VeriduSettings["secret"], version=VeriduSettings["version"])
session = Session(api)

# creates new a read/write Veridu session
# more info: https://veridu.com/wiki/Session_Resource
session.create(False)
# assigns the fresh Veridu session to user
# more info: https://veridu.com/wiki/User_Resource
session.assign(username)

print("""
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <!-- Loading the jQuery Library (required by Widget Library) -->
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <!-- Loading the Widget Library (more info: https://veridu.com/wiki/Widget_Library) -->
        <script type="text/javascript" src="https://assets.veridu.com/%(version)s/sdk/veridu-widget.js"></script>
    </head>
    <body>
        <!-- Widget Container -->
        <div id="widget" style="width: 100%%; height: 540px"></div>
        <script type="text/javascript">
            var //Widget instantiation
                veridu = new Veridu({
                    client: '%(client)s',
                    session: '%(token)s',
                    language: 'en-us',
                    country: 'uk',
                    version: '%(version)s'
                });
                //displaying the profile widget
                //more info: https://veridu.com/wiki/Challenge_Widget
                veridu.Widget.challenge(
                    $('#widget'),
                    '%(username)s',
                    {
                        setup: ['facebook','linkedin','paypal','amazon','twitter','google','instagram','yahoo','email','sms','spotafriend','personal','document']
                    }
                );
                $(document).on('VeriduEvent', function (event, data) {
                    if (data.eventname === 'UserProfile') {
                        if (typeof console !== 'undefined') {
                            console.log(data.user, data.profile);
                        }
                    }
                });
        </script>
    </body>
</html>
""" % {"username": username, "client": VeriduSettings["key"], "version": VeriduSettings["version"], "token": session.getToken()})
