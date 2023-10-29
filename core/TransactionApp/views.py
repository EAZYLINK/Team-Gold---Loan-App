# views.py

from rest_framework import generics
from rest_framework import status
from .models import NativeTransaction
from .serializers import NativeTransactionSerializer
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from rest_framework.views import APIView

class NativeTransactionListCreateView(APIView):
    permission_classes = [IsAuthenticated]

    def get(self, request):
        transactions = NativeTransaction.objects.filter(user=request.user)
        serializer = NativeTransactionSerializer(transactions, many=True)
        return Response(serializer.data)

    def post(self, request):
        serializer = NativeTransactionSerializer(data=request.data)

        if serializer.is_valid():
            serializer.save(user=request.user)
            return Response(serializer.data, status=status.HTTP_201_CREATED)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    


class DepositView(APIView):
    permission_classes = [IsAuthenticated]

    def post(self, request):
        amount = request.data.get('amount')
        source = request.data.get('source')

        if amount and source:
            # Perform the deposit operation (payment gateway integration required)
            transaction = NativeTransaction(user=request.user, amount=amount, transaction_type='deposit', source=source, status='completed')
            transaction.save()
            return Response(NativeTransactionSerializer(transaction).data, status=status.HTTP_201_CREATED)
        else:
            return Response({'error': 'Both amount and source are required.'}, status=status.HTTP_400_BAD_REQUEST)



class WithdrawalView(APIView):
    permission_classes = [IsAuthenticated]

    def post(self, request):
        amount = request.data.get('amount')
        destination = request.data.get('destination')

        if amount and destination:
            # Perform the withdrawal operation (payment gateway integration required)
            transaction = NativeTransaction(user=request.user, amount=amount, transaction_type='withdrawal', destination=destination, status='completed')
            transaction.save()
            return Response(NativeTransactionSerializer(transaction).data, status=status.HTTP_201_CREATED)
        else:
            return Response({'error': 'Both amount and destination are required.'}, status=status.HTTP_400_BAD_REQUEST)



class TransferView(APIView):
    permission_classes = [IsAuthenticated]

    def post(self, request):
        amount = request.data.get('amount')
        destination = request.data.get('destination')

        if amount and destination:
            # Perform the transfer operation (payment gateway integration required)
            # Assuming a transfer is a withdrawal from the sender and a deposit to the recipient
            transaction_sender = NativeTransaction(user=request.user, amount=amount, transaction_type='transfer', source='self', status='completed')
            transaction_sender.save()

            transaction_recipient = NativeTransaction(user=destination.user, amount=amount, transaction_type='transfer', destination='self', status='completed')
            transaction_recipient.save()

            return Response({'message': 'Transfer completed'}, status=status.HTTP_201_CREATED)
        else:
            return Response({'error': 'Both amount and destination are required.'}, status=status.HTTP_400_BAD_REQUEST)
