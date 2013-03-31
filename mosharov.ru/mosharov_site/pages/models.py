from django.db import models

# Create your models here.

class Sections(models.Model):
    section_name = models.CharField(max_length = 255)
    section_title = models.CharField(max_length=255)
    section_url = models.URLField(unique=True)
    section_text = models.TextField()
    section_create_date = models.DateTimeField(auto_now=True, auto_now_add = True)
    section_publish = models.SmallIntegerField()
    section_publish_in_menu = models.SmallIntegerField()
    