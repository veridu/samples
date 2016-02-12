#!/usr/bin/env python

from time import sleep

# importing SDK modules
from Veridu.SDK.API import API
from Veridu.SDK.Session import Session

# importing client configuration
from settings import VeriduSettings

# Change this to your system's user id
username = "unique-user-id";

# API and Session SDK instantiation
# more info: https://github.com/veridu/veridu-python
api = API(VeriduSettings["key"], VeriduSettings["secret"], VeriduSettings["version"])
session = Session(api)

# creates new a read/write Veridu session
# more info: https://veridu.com/wiki/Session_Resource
session.create(False)
# assigns the fresh Veridu session to user
# more info: https://veridu.com/wiki/User_Resource
session.assign(username)

# mimics form data
data = {
    "firstname": "",
    "lastname": "",
    "birthyear": "",
    "birthmonth": "",
    "birthday": "",
    "address1": "",
    "postcode": ""
}

# sends the form data
# more info: https://veridu.com/wiki/Personal_Resource
response = api.fetch("GET", "personal/%s" % username)
if response["state"]:
    api.fetch("PUT", "personal/%s" % username, data)
else:
    api.fetch("POST", "persoanl/%s" % username, data)

response = api.signedFetch(
    "POST",
    "check/%s/tracesmart" % username,
    {
        "setup": "address,dob"
    }
)

# prints API response
# for example: {'status': True, 'task_id': 5061}
# more details: https://veridu.com/wiki/Check_Resource#How_to_create_a_new_Background_Check
print response

# Polling API to wait until check is done
# Note: can be done via WebHook without polling
taskId = response["task_id"]
response = api.fetch("GET", "task/%(username)s/%(taskid)s" % {"username": username, "taskid": taskId})
while response["info"]["running"]:
    sleep(0.5)
    response = api.fetch("GET", "task/%(username)s/%(taskid)s" % {"username": username, "taskid": taskId})

# retrieves background check result
# more info: https://veridu.com/wiki/Check_Resource
response = api.signedFetch("GET", "check/%s/tracesmart" % username)

# prints API response
# more details: https://veridu.com/wiki/Check_Resource#How_to_retrieve_data_from_one_provider
print response
