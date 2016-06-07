Base Bundle
User management and commont tools 

to activate add 

```
$bundles = array(
    new Coyote\BaseBundle\CoyoteBaseBundle(),
);
```

to the bundles 

then update the routing

config
```
coyote_base:
  roles:
    - label: Super Admin
      name: ROLE_SUPER_ADMIN
```
