# Create your views here.
from django.shortcuts import render_to_response

def search_form(request):
    return render_to_response('search_form.html')

def search(request):
    if 'q' in request.GET:
        get = request.GET['q']
    else:
        get = ""
    return render_to_response('search_form.html', {'get' : get})