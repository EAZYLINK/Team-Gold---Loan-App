from django.db import models
from django.conf import settings
import uuid



# models.py

class NativeTransaction(models.Model):
    TRANSACTION_TYPES = (
        ('deposit', 'Deposit'),
        ('withdrawal', 'Withdrawal'),
        ('transfer', 'Transfer'),
    )

    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    user = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    transaction_type = models.CharField(max_length=20, choices=TRANSACTION_TYPES)
    created_at = models.DateTimeField(auto_now_add=True)
    source = models.CharField(max_length=100)
    destination = models.CharField(max_length=100, blank=True, null=True)
    status = models.CharField(max_length=20, default='pending')

    def __str__(self):
        return f'{self.user.email}"s transaction - type: ${self.transaction_type}'

