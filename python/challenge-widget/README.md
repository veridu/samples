# Challenge Widget Code Sample
Identity Challenge during a verification process.

This sample uses the [Widget Library](https://veridu.com/wiki/Widget_Library) to create a challenge process.

## Files
 * [challenge-widget/index.py](index.py): entry point for the challenge process
 * [challenge-widget/settings.py.dist](settings.py.dist): distribution settings file (copy this file to settings.py)

## Requirements
 * [PyPi](https://pypi.python.org/pypi): Dependency manager for Python
 * [Python-SDK](https://github.com/veridu/veridu-python): Veridu's Python SDK
 * [Widget Library](https://veridu.com/wiki/Widget_Library): Veridu's Widget Library

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

On your webbrowser navigate to [http://127.0.0.1:8000/challenge-widget/index.py](http://127.0.0.1:8000/challenge-widget/index.py).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need to do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the Python SDK?](https://veridu.com/wiki/How_do_I_use_the_Python_SDK%3F)
 * [How do I retrieve a user's Verified Profile?](https://veridu.com/wiki/How_do_I_retrieve_a_user%27s_Verified_Profile%3F)
 * [How do I display the verification widget?](https://veridu.com/wiki/How_do_I_display_the_verification_widget%3F)
 * [Widget Library](https://veridu.com/wiki/Widget_Library)
