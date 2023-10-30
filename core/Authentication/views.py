# views.py
from rest_framework import generics
from rest_framework.response import Response
from rest_framework import status
from .models import Users
from .serializers import RegistrationSerializer
from rest_framework.views import APIView
from rest_framework.authtoken.models import Token
from django.contrib.auth import authenticate
from .models import UserProfile
from .serializers import UserProfileSerializer
from rest_framework.permissions import IsAuthenticated
import uuid

from django.utils.http import urlsafe_base64_encode
from django.utils.encoding import force_bytes
from django.contrib.sites.models import Site
from django.template.loader import render_to_string
from django.core.mail import send_mail


from .tokens import account_activation_token  # You'll need to create a custom token for email verification

class UserRegistrationView(APIView):
    def post(self, request):
        serializer = RegistrationSerializer(data=request.data)
        if serializer.is_valid():
            email = serializer.validated_data['email']
            password = serializer.validated_data['password']

            # Create and save the user with a UUID as the ID
            user_id = uuid.uuid4()  # Generate a random UUID
            user = Users(id=user_id, email=email)
            user.set_password(password)
            user.save()

            # Generate an email verification token for the user
            token = account_activation_token(user)

           # Send an email with a verification link
            current_site = Site.objects.get_current()
            mail_subject = "Activate your account"
            message = render_to_string(
                "account/activation_email.html",
                {
                    "user": user,
                    "domain": current_site.domain,
                    "uid": urlsafe_base64_encode(force_bytes(user.pk)),  # Generate the uid
                    "token": token,
                },
            )
            send_mail(mail_subject, message, "breezeconcept3@gmail.com", [user.email])

            return Response({'message': 'User registration successful'}, status=status.HTTP_201_CREATED)

        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    



class UserProfileView(APIView):
    permission_classes = [IsAuthenticated]
    def get(self, request):
        # Check if the user has a profile, and if not, create one
        profile, created = UserProfile.objects.get_or_create(user=request.user)
        serializer = UserProfileSerializer(profile)
        return Response(serializer.data)

    def put(self, request):
        # Update the user's profile
        profile, created = UserProfile.objects.get_or_create(user=request.user)
        serializer = UserProfileSerializer(profile, data=request.data)
        if serializer.is_valid():
            serializer.save()
            # print(serializer.data)
            return Response(serializer.data)
        print(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    


# class EmailVerificationView(APIView):
#     def get(self, request, token):
#         try:
#             # Verify the token and update is_verified if successful
#             user = UserProfile.objects.get(id=token, is_verified=False).user
#             user.userprofile.is_verified = True
#             user.userprofile.save()
#             return Response({'message': 'Email verification successful'}, status=status.HTTP_200_OK)
#         except (UserProfile.DoesNotExist, ValueError):
#             return Response({'error': 'Invalid or expired token'}, status=status.HTTP_400_BAD_REQUEST)


from django.core.exceptions import ObjectDoesNotExist
from django.utils.http import urlsafe_base64_decode  # Corrected import

class EmailVerificationView(APIView):
    def get(self, request, token):
        try:
            # Decode the token (if it's base64-encoded)
            try:
                user_id = urlsafe_base64_decode(token).decode('utf-8')
            except (TypeError, ValueError, OverflowError):
                raise ValueError("Invalid token")

            # Verify the token and update is_verified if successful
            user_profile = UserProfile.objects.get(id=user_id, is_verified=False)
            user_profile.is_verified = True
            user_profile.save()
            return Response({'message': 'Email verification successful'}, status=status.HTTP_200_OK)
        except ObjectDoesNotExist:
            return Response({'error': 'Invalid or expired token'}, status=status.HTTP_400_BAD_REQUEST)
        except ValueError as e:
            return Response({'error': str(e)}, status=status.HTTP_400_BAD_REQUEST)


class CustomLoginView(APIView):
    def post(self, request):
        email = request.data.get('email')
        password = request.data.get('password')

        if email and password:
            user = authenticate(request, username=email, password=password)

            if user:
                token, created = Token.objects.get_or_create(user=user)
                return Response({'token': token.key}, status=status.HTTP_200_OK)
            else:
                return Response({'error': 'Invalid email or password.'}, status=status.HTTP_401_UNAUTHORIZED)
        else:
            return Response({'error': 'Please provide both email and password.'}, status=status.HTTP_400_BAD_REQUEST)



class LogoutView(APIView):
    def post(self, request):
        # Get the user's token
        token = request.auth
        if token:
            # Delete the token
            token.delete()
            return Response({'message': 'Logged out successfully'}, status=status.HTTP_200_OK)
        else:
            return Response({'error': 'No token found'}, status=status.HTTP_400_BAD_REQUEST)










































# class CustomLoginView(ObtainAuthToken):
#     def post(self, request, *args, **kwargs):
#         email = request.data.get('email')
#         password = request.data.get('password')

#         if email and password:
#             request.data['username'] = email
#             response = super(CustomLoginView, self).post(request, *args, **kwargs)

#             if response.status_code == status.HTTP_200_OK:
#                 # If login is successful, generate and return a token
#                 user = Token.objects.get(user=response.data['user'])
#                 response.data['token'] = user.key

#             return response
#         else:
#             return Response({'error': 'Please provide both email and password.'}, status=status.HTTP_400_BAD_REQUEST)






# class UserProfileView(APIView):
#     def get(self, request):
#         # Retrieve the user's profile
#         profile = UserProfile.objects.get(user=request.user)
#         serializer = UserProfileSerializer(profile)
#         return Response(serializer.data)

#     def put(self, request):
#         # Update the user's profile
#         profile = UserProfile.objects.get(user=request.user)
#         serializer = UserProfileSerializer(profile, data=request.data)
#         if serializer.is_valid():
#             serializer.save()
#             return Response(serializer.data)
#         return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)



