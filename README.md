# Installation

```bash
composer require --dev turkpin/maker
ln -s vendor/turkpin/maker/make make
chmod +x make
```

# Usage

- **php make User** makes the following files:

  - controllers/UsersController.php
  - models/User/UserRepository.php
  - models/User/UserService.php
  - models/User/UserFactory.php
  - models/User/UserSeeder.php
  - models/User/User.php

- **php make controller User** makes the following files:

  - controllers/UsersController.php

- **php make model User** makes the following files:

  - models/User/UserRepository.php
  - models/User/UserService.php
  - models/User/UserFactory.php
  - models/User/UserSeeder.php
  - models/User/User.php

- **php make repository User** makes the following files:

  - models/User/UserRepository.php

- **php make service User** makes the following files:

  - models/User/UserService.php

- **php make entity User** makes the following files:

  - models/User/User.php

- **php make User Address Billing** makes the following files:

  - controllers/User/AddressController.php
  - controllers/User/BillingController.php
  - models/User/Address/AddressRepository.php
  - models/User/Address/AddressService.php
  - models/User/Address/AddressFactory.php
  - models/User/Address/AddressSeeder.php
  - models/User/Address/Address.php
  - models/User/Billing/BillingRepository.php
  - models/User/Billing/BillingService.php
  - models/User/Billing/BillingFactory.php
  - models/User/Billing/BillingSeeder.php
  - models/User/Billing/Billing.php

- **php make controller User Address Billing** makes the following files:

  - controllers/User/AddressController.php
  - controllers/User/BillingController.php

- **php make model User Address Billing** makes the following files:
  - models/User/Address/AddressRepository.php
  - models/User/Address/AddressService.php
  - models/User/Address/AddressFactory.php
  - models/User/Address/AddressSeeder.php
  - models/User/Address/Address.php
  - models/User/Billing/BillingRepository.php
  - models/User/Billing/BillingService.php
  - models/User/Billing/BillingFactory.php
  - models/User/Billing/BillingSeeder.php
  - models/User/Billing/Billing.php
