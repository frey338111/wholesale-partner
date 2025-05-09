# Wholesale_PartnerPortal

A custom Magento 2 module that provides a Partner Portal for managing wholesale partners with support for admin UI, frontend display, image upload, and GraphQL integration.

---

## 🔧 Features

- Manage partners from the Magento Admin Panel
- Upload and display partner logos
- Custom frontend route for viewing partner details
- Friendly URLs using `slug`
- Admin grid with inline actions (edit/delete)
- Image upload to `pub/media/wholesale/`
- GraphQL support: fetch partner by slug

---

## 🚀 Installation

1. Copy the module to `app/code/Wholesale/PartnerPortal`
2. Run the following commands:

```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
