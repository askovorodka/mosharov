# -*- coding: utf-8 -*-
from django.db import models
import os
import uuid
from django.conf import settings

# Create your models here.

class Sections(models.Model):
    section_name = models.CharField(max_length = 255,verbose_name="Название раздела")
    section_title = models.CharField(max_length=255, verbose_name="Тайтл раздела")
    section_url = models.CharField(max_length=255, verbose_name="URL раздела")
    section_text = models.TextField(verbose_name="Текст раздела")
    section_create_date = models.DateTimeField(verbose_name="Дата создания")
    
    MAYBECHOICE = (('0', 'Нет'),  ('1', 'Да'),)

    section_publish = models.CharField(choices=MAYBECHOICE, verbose_name="Показывать на сайте", max_length=1)
    section_publish_in_menu = models.CharField(choices=MAYBECHOICE, verbose_name="Показывать в меню", max_length=1)
    
    class Meta:
        ordering = ["section_name"]
        
    
    def __unicode__(self):
        return '%s' % self.section_name
    
class SectionImage(models.Model):
    
    def generate_new_filename(instance, filename):
        f, ext = os.path.splitext(filename)
        return 'section_image/%s%s' % (uuid.uuid4().hex, ext)
    
    section = models.ForeignKey(Sections)
    #image = models.ImageField(upload_to='section_image')
    image = models.ImageField(upload_to=generate_new_filename)

    def preview_image(self):
        image_path = os.path.join(settings.MEDIA_URL, self.image.url)
        return u'<img src="%s" width="100">' % image_path
    
    preview_image.short_description = 'Thumbnail'
    preview_image.allow_tags = True
    
    def __unicode__(self):
        return '%s' % self.image