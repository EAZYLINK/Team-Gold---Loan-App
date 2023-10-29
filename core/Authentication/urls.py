from django.urls import path
from .views import UserRegistrationView, UserProfileView, CustomLoginView, LogoutView, EmailVerificationView

urlpatterns = [
    path('register', UserRegistrationView.as_view(), name='user-registration'),
    path('profile', UserProfileView.as_view(), name='user-profile'),
    path('login', CustomLoginView.as_view(), name='api_login'),
    path('logout', LogoutView.as_view(), name='logout'),
    path('email-verify/<str:token>/', EmailVerificationView.as_view(), name='email-verify'),
    # Add more API endpoints as needed
]