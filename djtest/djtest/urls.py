from django.conf.urls import patterns, include, url
from django.contrib import admin
from djtest.views import home, test_request
from content import views

admin.autodiscover()

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    # Examples:
     #url(r'^$', 'djtest.views.home', name='home'),
     url(r'^$', home),
     url(r'^test_request/', test_request),
    # url(r'^djtest/', include('djtest.foo.urls')),

    # Uncomment the admin/doc line below to enable admin documentation:
    # url(r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    url(r'^admin/', include(admin.site.urls)),
    
    url(r'^search_form/$', views.search_form),
    
    url(r'^search/$', views.search),
)
