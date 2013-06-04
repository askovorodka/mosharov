# -*- coding: utf-8 -*-

from django.http import HttpResponse
from pages.models import Sections
from django.shortcuts import render_to_response

def home(request):
    #sections = Sections.objects.order_by('section_create_date')
    #print sections
    return HttpResponse ("Главная страница сайта3")

def pages(request):
    sections = Sections.objects.order_by('section_create_date')
    return render_to_response("pages/pages.html", {'sections' : sections})