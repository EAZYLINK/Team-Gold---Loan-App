from django.db.models.signals import post_save
from django.dispatch import receiver
from .models import UserProfile
from django.conf import settings
import uuid

@receiver(post_save, sender=settings.AUTH_USER_MODEL)
def create_user_profile(sender, instance, created, **kwargs):
    if created:
        UserProfile.objects.create(id=uuid.uuid4(), user=instance)
