from rest_framework.views import APIView
from rest_framework.response import Response
from rest_framework import status
from .serializers import LoanSerializer, LoanRequestSerializer, LoanReviewSerializer, LoanTransactionSerializer
from .models import Loan, LoanRequest, LoanReview, LoanTransaction

class LoanListCreateView(APIView):
    def get(self, request):
        loans = Loan.objects.all()
        serializer = LoanSerializer(loans, many=True)
        return Response(serializer.data)

    def post(self, request):
        serializer = LoanSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class LoanRequestListCreateView(APIView):
    def get(self, request):
        loan_requests = LoanRequest.objects.all()
        serializer = LoanRequestSerializer(loan_requests, many=True)
        return Response(serializer.data)

    def post(self, request):
        serializer = LoanRequestSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class LoanReviewListCreateView(APIView):
    def get(self, request):
        loan_reviews = LoanReview.objects.all()
        serializer = LoanReviewSerializer(loan_reviews, many=True)
        return Response(serializer.data)

    def post(self, request):
        serializer = LoanReviewSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class LoanTransactionListCreateView(APIView):
    def get(self, request):
        transactions = LoanTransaction.objects.all()
        serializer = LoanTransactionSerializer(transactions, many=True)
        return Response(serializer.data)

    def post(self, request):
        serializer = LoanTransactionSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
