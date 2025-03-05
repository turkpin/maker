# Installation

```bash
composer require --dev turkpin/maker
```
```bash
ln -s vendor/turkpin/maker/make make
```
```bash
chmod +x make
```

# Usage

<table>

  <tr>
    <td><pre>php make User</pre></td>
    <td>
<pre>
controllers/UsersController.php
models/User/UserRepository.php
models/User/UserService.php
models/User/UserFactory.php
models/User/UserSeeder.php
models/User/User.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make controller User</pre></td>
    <td>
<pre>
controllers/UsersController.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make model User</pre></td>
    <td>
<pre>
models/User/UserRepository.php
models/User/UserService.php
models/User/UserFactory.php
models/User/UserSeeder.php
models/User/User.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make repository User</pre></td>
    <td>
<pre>
models/User/UserRepository.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make service User</pre></td>
    <td>
<pre>
models/User/UserService.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make entity User</pre></td>
    <td>
<pre>
models/User/User.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make User Address Billing</pre></td>
    <td>
<pre>
controllers/User/AddressController.php
controllers/User/BillingController.php
models/User/Address/AddressRepository.php
models/User/Address/AddressService.php
models/User/Address/AddressFactory.php
models/User/Address/AddressSeeder.php
models/User/Address/Address.php
models/User/Billing/BillingRepository.php
models/User/Billing/BillingService.php
models/User/Billing/BillingFactory.php
models/User/Billing/BillingSeeder.php
models/User/Billing/Billing.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make controller User Address Billing</pre></td>
    <td>
<pre>
controllers/User/AddressController.php
controllers/User/BillingController.php
</pre>
    </td>
  </tr>

  <tr>
    <td><pre>php make model User Address Billing</pre></td>
    <td>
<pre>
models/User/Address/AddressRepository.php
models/User/Address/AddressService.php
models/User/Address/AddressFactory.php
models/User/Address/AddressSeeder.php
models/User/Address/Address.php
models/User/Billing/BillingRepository.php
models/User/Billing/BillingService.php
models/User/Billing/BillingFactory.php
models/User/Billing/BillingSeeder.php
models/User/Billing/Billing.php
</pre>
    </td>
  </tr>

<table>
