# Lumen ❤️ JWT

For my various projects, I had a recurring need to design APIs, and Lumen seems to me the most suitable.
In order to add security, I decided to adopt JWT with a role system, in order to best secure the different endpoints.

## 🚀 Stack

-   Lumen : **8.2.4**
-   jwt-auth : **1.0.2**
-   lumen-config-discover : **1.0.1**

## 👥 Role-based

The role-based system is based on the "users" table, you can add roles like admin, moderator, user ...
Subsequently, in order to secure your routes for a certain type of role, you must add the "auth.role:xxx" middleware, for example the route with the "auth.role: admin" middleware will only be accessible by a user whose role will be "admin".
