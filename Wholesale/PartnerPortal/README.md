# Wholesale_PartnerPortal

A custom Magento 2 module that provides a Partner Portal for managing wholesale partners with support for admin UI, frontend display, image upload, and GraphQL integration.

---

## 🔧 Features

- Manage partners from the Magento Admin Panel
- Upload and display partner logos
- Custom frontend route for viewing partner details
- Friendly URLs using `slug`
- Image upload to `pub/media/partnerlogo/`
- GraphQL support: list or seach partner by name 

---

## 🚀 Installation

1. Copy the module to `app/code/Wholesale/PartnerPortal`
2. Run the following commands:

```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
