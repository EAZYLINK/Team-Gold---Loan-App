from django.db import models
from django.conf import settings
import uuid

class Loan(models.Model):
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    lender = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    loan_amount = models.DecimalField(max_digits=10, decimal_places=2)
    interest_rate = models.FloatField()
    loan_term = models.PositiveIntegerField()
    # Add more fields as needed

    def __str__(self):
        return f"Loan created by {self.lender.email}"

class LoanRequest(models.Model):
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    borrower = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    loan = models.ForeignKey(Loan, on_delete=models.CASCADE)
    status = models.CharField(max_length=20, default='requested')  # Other possible statuses: approved, declined
    # Add more fields as needed

    def __str__(self):
        return f"Loan requested by {self.borrower.email}"
    


class LoanReview(models.Model):
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    loan_request = models.ForeignKey(LoanRequest, on_delete=models.CASCADE)
    reviewer = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    is_approved = models.BooleanField()
    review_comments = models.TextField()
    # Add more fields as needed

    def __str__(self):
        return f"Loan reviewed by {self.reviewer.email}"


# Create your models here.

class LoanTransaction(models.Model):
    id = models.UUIDField(primary_key=True, default=uuid.uuid4, editable=False)
    from_user = models.ForeignKey(settings.AUTH_USER_MODEL, related_name='transactions_sent', on_delete=models.CASCADE)
    to_user = models.ForeignKey(settings.AUTH_USER_MODEL, related_name='transactions_received', on_delete=models.CASCADE)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    # Add more fields as needed

    def __str__(self):
        return f"Loan sent by {self.from_user.email} to {self.to_user.email}"