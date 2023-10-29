# urls.py

from django.urls import path
from . import views

urlpatterns = [
    path('native_transactions', views.NativeTransactionListCreateView.as_view(), name='transaction-list-create'),
    path('deposit', views.DepositView.as_view(), name='deposit'),
    path('withdrawal', views.WithdrawalView.as_view(), name='withdrawal'),
    path('transfer', views.TransferView.as_view(), name='transfer'),
]
