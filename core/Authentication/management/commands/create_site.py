from django.core.management.base import BaseCommand
from django.contrib.sites.models import Site

class Command(BaseCommand):
    help = 'Create a Site object for the production domain'

    def handle(self, *args, **options):
        domain = '127.0.0.1:8000'  # Replace with your actual production domain
        name = 'localhost'  # Replace with your site's name
        site, created = Site.objects.get_or_create(domain=domain, name=name)

        if created:
            self.stdout.write(self.style.SUCCESS(f'Successfully created Site object for {domain}'))
        else:
            self.stdout.write(self.style.SUCCESS(f'Site object for {domain} already exists'))

