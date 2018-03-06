# FSClientBundle

This is a client bundle to consume the NTIFS service/micro-service.

### Process

### Configuration

In your `config.yml`:

```
// ...
ntifs_client:
    endpoint: http://[NTIFS_URL]/
    app_name: [ASSIGNED_APP_NAME]
    auth_key: [ASSIGNED_AUTH_KEY]
```