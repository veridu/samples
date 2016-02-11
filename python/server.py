#!/usr/bin/env python

import BaseHTTPServer
import CGIHTTPServer
import cgitb;

cgitb.enable()

handler = CGIHTTPServer.CGIHTTPRequestHandler
handler.cgi_directories = [
    "/background-check",
    "/challenge-api/oAuth1",
    "/challenge-api/oAuth2",
    "/challenge-widget",
    "/sso-api/oAuth1",
    "/sso-api/oAuth2",
    "/sso-widget"
]

httpd = BaseHTTPServer.HTTPServer(("0.0.0.0", 8000), handler)
httpd.serve_forever()
