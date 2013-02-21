from django.contrib import admin
from content.models import Authors, Articles

class AuthorsAdmin(admin.ModelAdmin):
    list_display = ('name','email')
    search_fields = ('name','email')

class ArticlesAdmin(admin.ModelAdmin):
    list_display = ('name', 'date')
    list_filter = ('date',)
    date_hierarchy = 'date'
    ordering = ('-date',)
    #fields = ('name','description','text','author','image')
    filter_horizontal = ('author',)

admin.site.register(Authors, AuthorsAdmin)
admin.site.register(Articles, ArticlesAdmin)