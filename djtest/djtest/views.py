# -*- coding: utf-8 -*-
from django.http import HttpResponse
from django.shortcuts import render_to_response

def home(request):
    return HttpResponse("Привет")

def test_request(request):
    values = request.META.items()
    values.sort()
    return render_to_response('test_request.html',{ 'values' : values, 'get' : request.GET })
