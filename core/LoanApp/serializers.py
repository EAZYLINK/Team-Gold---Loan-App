from rest_framework import serializers
from .models import Loan, LoanRequest, LoanReview, LoanTransaction

class LoanSerializer(serializers.ModelSerializer):
    class Meta:
        model = Loan
        fields = '__all__'

class LoanRequestSerializer(serializers.ModelSerializer):
    class Meta:
        model = LoanRequest
        fields = '__all__'

class LoanReviewSerializer(serializers.ModelSerializer):
    class Meta:
        model = LoanReview
        fields = '__all__'

class LoanTransactionSerializer(serializers.ModelSerializer):
    class Meta:
        model = LoanTransaction
        fields = '__all__'
