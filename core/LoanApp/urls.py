from django.urls import path
from . import views

urlpatterns = [
    # Define the URL patterns for the Loan models
    path('loans', views.LoanListCreateView.as_view(), name='loan-list'),
    path('loan_requests', views.LoanRequestListCreateView.as_view(), name='loan-request-list'),
    path('loan_reviews', views.LoanReviewListCreateView.as_view(), name='loan-review-list'),
    path('loan_transactions', views.LoanTransactionListCreateView.as_view(), name='transaction-list'),
]
