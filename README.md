# The Big Event management software

This application can be used to coordinate the logistics of planning The Big Event in your area.

The application can accept job requests, group management, and group-job assignments, as well as email.

# Installation

1. Clone the repository

```bash
git clone http://github.com/uwyoslce/thebigevent
```

2. Install the dependencies with Composer

```bash
php composer.phar install
```

3. Set up the database
Execute `config/schema/install.sql` against your database.

4. Copy `app.default.php` to `app.php` and make adjustments for your event.

5. Set up beginning data

Visit `https://yourbigevent.com/conditions` to set up a pick list of conditions that you can assign to sites and users.  Users can explicitly opt in and opt out of conditions.  Example conditions include "Wheelchair Accessible" or "Dog(s) on site"

Visit `https://yourbigevent.com/tools` to pre-populate a few tables needed for managing your event.

Visit `https://yourbigevent.com/documents` to set up documents that your users must sign.

Visit `https://yourbigevent.com/tasks` to set up tasks that can be associated with jobs

Visit `https://yourbigevent.com/todo-templates` to set up templates for todo items that will be auto-assigned to your committee.

Visit `https://yourbigevent.com/jobs/map` to see jobs displayed on a map.