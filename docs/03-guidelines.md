# Guidelines

## Table of Contents

- [Performance](#user-content-performance)
- [Security](#user-content-security)
- [Custom Tables](#user-content-custom-tables)
- [Data Consistency](#user-content-data-consistency)
- [Magento](#user-content-magento)

## Performance

Since this tool is a pure PHP implementation of a MySQL dumper, it is way slower than mysqldump.

If the database to dump has very large tables, it is strongly recommended to use the [table filter](01-configuration.md#user-content-filtering-values) mechanism.

## Security

On production environments, it is recommended to use two separate configuration files:

- A file that contains the dump output settings and the anonymization rules.
  This file should be versioned in the VCS repository of your project.
- A file that contains the database information (name, host, user, password...).
  This file **must not** be versioned, it contains the database password.

Example:

```
bin/gdpr-dump path/to/project_anonymization.yaml path/to/database_info.yaml
```

## Custom Tables

If your project has custom tables with sensible data, your config file must declare converters that anonymizes this data.

Example of sensible data:

- email
- username
- name
- date of birth
- phone number
- address
- IP address
- encrypted password
- payment data
- comment that could contain customer-related information

## Data Consistency

If you use the default templates (e.g. `magento2`), the anonymized data is not consistent.
For example, the anonymized customer email won't have the same value between the customer table and the quote table.

You can add data consistency by specifying a [cache key](01-configuration.md#user-content-sharing-converter-results).
For example, in Magento 2:

```yaml
tables:
    customer_entity:
        converters:
            email:
                cache_key: 'customer_email'
                unique: true

    customer_flat_grid:
        converters:
            email:
                cache_key: 'customer_email'
                unique: true

    # ... repeat this for each table that stores a customer email
```

With the above configuration, each table will use the same anonymized email for each customer.

Warning: this can use **a lot** of memory depending on the number of values to memorize (approximately 1G for 10 million values).

## Magento

**Performance**

To speed up the dump creation, temporary tables are automatically truncated:

- cache tables
- session tables
- log tables
- index tables: `*_idx`, `*_cl`, `*_replica`
- temporary tables: `*_tmp`

Quote tables are not truncated by default.
If these tables contain a lot of values, adding filters to these tables will speed up the dump creation.

For example (Magento 2):

```yaml
tables:
    quote:
        truncate: true
```

**Admin Accounts**

The `magento1` and `magento2` templates anonymize all admin accounts.

If you want to keep the email/password for some accounts, you can set a condition on the `admin_user` table.

Example:

```yaml
tables:
    admin_user:
        skip_conversion_if: '{{username}} === "admin123"'
```

**Payment Data**

In Magento 1 and Magento 2, the payment data is partially stored in a column named `additional_information`.
The data is stored as a serialized array.
Only the `CC_CN` property is anonymized by the `magento1` and `magento2` templates.

If this column contains other sensible data in your project, you must anonymize it in your custom config file.
For example, in Magento 1:

```yaml
tables:
    sales_flat_quote_payment:
        converters:
            additional_information:
                parameters:
                    converters:
                        fieldToAnonymize:
                            converter: 'anonymizeText'

    sales_flat_order_payment:
        converters:
            additional_information:
                parameters:
                    converters:
                        fieldToAnonymize:
                            converter: 'anonymizeText'
```

In Magento 2:

```yaml
tables:
    quote_payment:
        converters:
            additional_information:
                parameters:
                    converters:
                        fieldToAnonymize:
                            converter: 'anonymizeText'

    sales_order_payment:
        converters:
            additional_information:
                parameters:
                    converters:
                        fieldToAnonymize:
                            converter: 'anonymizeText'
```

The fields to anonymize will depend on the payment methods that are used in the project.
