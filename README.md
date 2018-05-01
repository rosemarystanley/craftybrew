# CraftyBrew

This is a simple example site that will help to demonstrate using Symfony 3, 
Doctrine 2, and some ES6 features in Javascript.

This site is by no means a completely bug-free or working example. However,
over time there are plans to enhance the site and potentially open it up for
outside contributions.

---

## Installation

To install the site, it is recommended to use [vagrant](https://www.vagrantup.com/downloads.html)
to set up the pre-configured environment.

Once installed, run `vagrant up` to create the new virtualbox instance. Then
open your web browser to `https://localhost/`. You will need to accept the
warning that the web browser will display, as the site does not currently use
HTTP.

## Code Structure

### PHP (Symfony)

All custom Symfony-related code goes into `./src` using the `\CraftyBrew\*` namespace. 

### Twig

All twig templates go under `./app/Resources/views/*`. Layouts are found in `./app/Resources/views/layouts/*`.

### SASS, Fixtures, Javascript... oh my!

Source assets are created and managed under `./app/Resources` in a subdirectory named after the asset type: `./sass` for SASS files, `./javascript` for Javascript, and `./fixtures` for database fixtures. When new types of assets are added, a folder for the type should be added as well.

## Development

Once `node`/`npm` and all project dependencies are installed, run `npm run start` to compile the assets. This will enable webpack's watch mode, so changes to assets will automatically be compiled.

#### // TODO: add either live reload, or hot module replacement

---

Thank you! And I hope to hear from you soon with jobs, ideas, or comments.
