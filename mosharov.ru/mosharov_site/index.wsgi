# -*- coding: utf-8 -*-

import os,sys,site

#path = '/home/alex/data/django/mysite'
#if path not in sys.path:
#    sys.path.append(path)

sys.path.insert(0, os.path.dirname(__file__))

#site.addsitedir('/home/alex/data/django/django')

os.environ['DJANGO_SETTINGS_MODULE'] = 'mosharov_site.settings'

os.environ['PYTHON_EGG_CACHE'] = '/tmp'

from django.core.handlers.wsgi import WSGIHandler

application = WSGIHandler()


