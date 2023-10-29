# serializers.py

from rest_framework import serializers
from .models import NativeTransaction

class NativeTransactionSerializer(serializers.ModelSerializer):
    class Meta:
        model = NativeTransaction
        fields = '__all__'
