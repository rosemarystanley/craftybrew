# Generating self-signed SSL certificates

## Generate a private key

  sudo openssl genrsa -des3 -out localhost.key 2048

## Remove passphrase

  sudo openssl rsa -in localhost.key -out localhost.key

## Generate the Certificate Signing Request

  sudo openssl req -new -key localhost.key -out localhost.csr

## Generate the Certificate

  sudo openssl x509 -req -days 1825 -in localhost.csr -signkey localhost.key -out localhost.crt

### Example input for certificate

```
Country Name (2 letter code) [AU]:US
State or Province Name (full name) [Some-State]:North Carolina
Locality Name (eg, city) []:Indian Trail
Organization Name (eg, company) [Internet Widgits Pty Ltd]:Rosemary Ann Designs
Organizational Unit Name (eg, section) []:Software Development
Common Name (e.g. server FQDN or YOUR name) []:localhost
Email Address []:

Please enter the following 'extra' attributes
to be sent with your certificate request
A challenge password []:
An optional company name []:
```
