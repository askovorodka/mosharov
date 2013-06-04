from django.contrib import admin
from pages.models import Sections, SectionImage

class SectionImageAdmin(admin.ModelAdmin):
    list_display = ('preview_image',)
        

admin.site.register(Sections)
admin.site.register(SectionImage, SectionImageAdmin)