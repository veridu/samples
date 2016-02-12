# Background Check API Code Sample
Traditional Background Check based on Credit data.

This sample uses the [Python-SDK](https://github.com/veridu/veridu-python) to integrate the background-check.

## Files
 * [background-check/index.py](index.py): entry point for the background-check process
 * [background-check/settings.py.dist](settings.py.dist): distribution settings file (copy this file to settings.py)

## Requirements
 * [PyPi](https://pypi.python.org/pypi): Dependency manager for Python
 * [Python-SDK](https://github.com/veridu/veridu-python): Veridu's Python SDK

## Setup Steps

### Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ pip install veridu-python
```

## Starting Application
Follow the instructions below to start the sample application using the simple HTTP server provided.
```bash
$ python -u server.py
```

On your webbrowser navigate to [http://127.0.0.1:8000/background-check/index.py](http://127.0.0.1:8000/background-check/index.py).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need to do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the Python SDK?](https://veridu.com/wiki/How_do_I_use_the_Python_SDK%3F)
 * [How do I create a Background Check?](https://veridu.com/wiki/How_do_I_create_a_Background_Check%3F)
 * [Check API EndPoint](https://veridu.com/wiki/Check_Resource)
