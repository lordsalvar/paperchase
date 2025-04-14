<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
## Flowchart
```mermaid
flowchart TD
    n11(["Start"]) --> n15["Document Creation"]
    n15 --> n16["Record Creator Info"]
    n16 --> n17{{"Input Data (DocName, DocType, Source, Details, Select Receiving Office(s), Generate QR Code)"}}
    n17 --> n18["Is Document for Dissemination only?"]
    n18 -- No --> n20["Assign Liaison and Scan their ID"]
    n18 -- Yes --> n19["Is Document == Soft Copy"]
    n19 -- Yes --> n21["Disseminate Soft Copy thru Web App"]
    n19 -- No --> n20
    n20 --> n22["Liaison Delivers Document(s)"]
    n22 --> n23["Receiving Office(s) Scans Document QR Code"]
    n23 --> n24["Receiving Office(s) Processes the Document(s) (Reviews, Edits, Logs)"]
    n24 --> n25["Document Needs to be Forwarded to a Different Office?"]
    n25 -- Yes --> n20
    n25 -- No --> n26["Receiving Office is Returning Document By Delivery?"]
    n26 -- No --> n27["Originating Office Liaisons pickups the Document and Deliver it back to their office"]
    n27 --> F["Documents is in its Finalized State/No Further Action is Required?"]
    F -- Yes --> G["END"]
    F -- No --> n20
    n21 --> G
    n26 -- Yes --> n28["Originating Office Receives Document"]
    n28 --> F
```
## ER Diagram
```mermaid
erDiagram
Document {
ulid id
string code
string title
ulid classification_id
ulid user_id
ulid office_id
ulid section_id
ulid source_id
datetime created_at
boolean directive
}
Classification {
ulid id
string name
string description
}
Office {
ulid id
string name
string head_name
string designation
string acronym
}
Sources{
ulid id
string name
}
Section {
ulid id
string name
ulid office_id
string head_name
string designation
}
Transmittal {
ulid id
ulid document_id
ulid from_office_id
ulid to_office_id
ulid from_section_id
ulid to_section_id
int from_user_id
int to_user_id
text remarks
datetime received_at
boolean pick_up
}
Contents {
ulid id
ulid transmittal_id
int copies
int pages_per_copy
string control_number
string particulars
string payee
double amount
}
User {
ulid id
ulid office_id
ulid section_id
string name
string email
string password
string role
string avatar
}
Attachments{
ulid id
string remarks
json files
json paths
ulid attachable_id
string attachable_type
}

    Transmittal }|--|| Document : "includes"
    Section || -- }| User : "has"
    Office || -- }| User : "has"
    Contents }|--|| Transmittal : "under"
    Transmittal }|--|| User : "sent by"
    Transmittal }|--|| User : "received by"
    Office ||--o{ Section : "has"
    Document }| -- || User : "can make"
    Office || -- }| Document : "can make"
    Section || -- }| Document : "can make"
    Classification ||--|{ Document : "classified as"
    Document }| -- o| Sources : "can have"
    Document || -- }| Attachments : "has many"
    Transmittal || -- }| Attachments : "has many"
``` 
