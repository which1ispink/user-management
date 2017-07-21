user-management
===============

### A REST API for a simple user management system

#### Routes:
- Add user: POST /api/user
- Delete user: DELETE /api/user/{id}
- Assign user to group: POST /api/user/{userId}/group/{groupId}
- Remove user from group: DELETE /api/user/{userId}/group/{groupId}
- Add group: POST /api/group
- Delete group: DELETE /api/group/{id}