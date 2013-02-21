# -*- coding: utf-8 -*-
from django.db import models

# Create your models here.

class Authors(models.Model):
    name = models.CharField(max_length=255, verbose_name='Имя автора')
    email = models.EmailField(verbose_name = 'Email автора')
    description = models.TextField(verbose_name='Доп.информация')
    
    def __unicode__(self):
        return self.name
    
    class Meta:
        ordering = ["name"]

class Articles(models.Model):
    name = models.CharField(max_length=255, verbose_name='Название статьи')
    date = models.DateTimeField(blank=True, null=True, verbose_name='Дата публикации')
    description = models.TextField(verbose_name='Краткое описание статьи')
    text = models.TextField(verbose_name='Текст статьи')
    image = models.ImageField(upload_to='images', blank=True, verbose_name='Картинка')
    author = models.ManyToManyField(Authors, verbose_name=u'Автор статьи')
    
    def __unicode__(self):
        return '%s' % self.name
