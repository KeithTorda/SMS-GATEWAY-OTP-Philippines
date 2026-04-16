<p align="center">
  <img src="docs/screenshots/send_sms.png" alt="SMS Gateway Philippines Dashboard" width="100%">
</p>

<div align="center">
  <h1 align="center">SMS Gateway & OTP Philippines</h1>

  <p align="center">
    High-performance SMS gateway and OTP management system for the Philippine market.
    <br />
    <a href="https://github.com/KeithTorda/SMS-GATEWAY-OTP-Philippines"><strong>Explore the Documentation »</strong></a>
    <br />
    <br />
    <a href="https://github.com/KeithTorda/SMS-GATEWAY-OTP-Philippines/issues">Report Issue</a>
    ·
    <a href="https://github.com/KeithTorda/SMS-GATEWAY-OTP-Philippines/issues">Request Feature</a>
    ·
    <a href="https://github.com/KeithTorda/SMS-GATEWAY-OTP-Philippines/pulls">Contributions</a>
  </p>
</div>

<details>
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#about-the-project">About The Project</a></li>
    <li><a href="#features">Features</a></li>
    <li><a href="#ideal-for">Ideal For</a></li>
    <li><a href="#built-with">Built With</a></li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#prerequisites">Prerequisites</a></li>
    <li><a href="#permissions">Permissions</a></li>
    <li><a href="#getting-started">Getting Started</a></li>
    <li><a href="#webhooks">Webhooks</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#links">Links</a></li>
  </ol>
</details>

---

## Preview

<p align="center">
  <img src="docs/screenshots/send_sms.png" width="32%" />
  <img src="docs/screenshots/message_logs.png" width="32%" /> 
  <img src="docs/screenshots/integration_guide.png" width="32%" />
</p>

---

## About The Project

This project provides a localized PHP implementation of a web-based dashboard and API gateway, designed for seamless integration with the **Android SMS Gateway** developed by [capcom6](https://github.com/capcom6/android-sms-gateway).

The system enables the transformation of an Android smartphone into a professional-grade SMS gateway localized for the Philippines. This lightweight application allows for programmatic SMS transmission via a unified API and provides real-time webhook notifications for message status updates. It is engineered for developers seeking to integrate SMS capabilities into their own applications or services using local Philippine cellular networks.

---

## Features

### Core Functionality
- **No registration required**: In local server mode, no external account creation is necessary.
- **API-Driven Communication**: Send and receive SMS messages programmatically via a RESTful API.
- **PHP and MySQL Architecture**: Built on a clean MVC framework designed for stability and high performance.
- **Regional Optimization**: Pre-configured support for major Philippine carriers including Globe, Smart, and DITO.

### Message Management
- **Multipart Message Support**: Automatic partitioning and transmission of long text messages.
- **Real-time Status Tracking**: Monitor message lifecycle stages (Sent, Delivered, Failed) through the centralized dashboard.
- **Comprehensive Activity Logs**: Detailed historical record of all message transactions with precise timestamps.

### Security and Infrastructure
- **Private Server Deployment**: Support for on-premise installation to ensure data sovereignty and security.
- **API Key Authentication**: Secure access management with the ability to generate and revoke integration keys.

---

## Use Cases
- **Authentication and Verification**: Implementation of secure two-factor authentication (2FA) for regional applications.
- **Transactional Notifications**: Automated confirmation of user actions and order status updates.
- **Automated Reminders**: Reliable scheduling of appointment and event notifications.
- **User Engagement**: Facilitation of direct user communication and feedback collection.

> [!IMPORTANT]
> **Operational Compliance**: It is not recommended to use this system for high-volume batch transmissions. Users must adhere to local mobile operator regulations regarding SMS traffic in the Philippines.

---

## Technical Stack
- **Backend Framework**: [PHP 7.4 / 8.x](https://php.net)
- **Database Engine**: [MySQL / MariaDB](https://mysql.com)
- **Frontend Components**: Vanilla CSS and modern layout utilities.
- **Core Integration**: [Android SMS Gateway App](https://github.com/capcom6/android-sms-gateway)

---

## Installation

### Prerequisites
- **Android Device**: Minimal requirement of Android 5.0 (Lollipop) or later.
- **Server Environment**: Web server (Apache/Nginx) with PHP 7.4+ support.
- **Database**: Active instance of MySQL or MariaDB.

### System Permissions
The following permissions must be granted to the companion Android application:
- `SEND_SMS`: Mandatory for message transmission.
- `READ_PHONE_STATE`: Optional (required for multi-SIM selection).
- `RECEIVE_SMS`: Optional (required for incoming message webhooks).

### Deployment from APK
1. Download the latest release from the [official repository](https://github.com/capcom6/android-sms-gateway/releases).
2. Install the APK on the target Android device.
3. Configure the application to either **Cloud** or **Private Server** mode, directed towards your server instance.

---

## Getting Started

### Environment Configuration
1. Clone the repository: `git clone https://github.com/KeithTorda/SMS-GATEWAY-OTP-Philippines.git`
2. Initialize environment variables: `cp .env.example .env`
3. Configure database credentials and application URL in the `.env` file.
4. Execute the database initialization script: `config/schema.sql`

### API Integration Example
```bash
curl -X POST -H "X-API-KEY: [YOUR_API_KEY]" \
  -H "Content-Type: application/json" \
  -d '{ "phone_number": "09---------", "message": "Notification from SMS Gateway Philippines." }' \
  https://[your-domain]/api/send
```

---

## Webhooks

The system provides real-time event notifications transmitted directly from the mobile hardware:

| Event Identifier | Description |
| :--- | :--- |
| `sms:sent` | Dispatched upon successful submission of the SMS message. |
| `sms:delivered` | Dispatched upon receipt of a carrier delivery confirmation. |
| `sms:failed` | Dispatched when a message fails to transmit through the cellular network. |

---

## Project Roadmap
- [ ] Support for multi-device account management.
- [ ] Implementation of advanced scheduling for batch notifications.
- [ ] Integration of SIM-level data analytics.
- [ ] International SMS routing capabilities.

---

## Contributing
We welcome contributions to improve the system.
1. **Fork** the repository.
2. Create a dedicated **Feature Branch**.
3. **Commit** your changes with descriptive messages.
4. **Push** the branch to your fork.
5. Submit a **Pull Request** for review.

---

## License and Credits
This project is licensed under the **MIT License**. Original Android implementation and hardware integration logic credited to [capcom6](https://github.com/capcom6).

---

## Contact and Support
**Keith Torda** - [GitHub Profile](https://github.com/KeithTorda)
Technical Support: [support@sms-gate.app](mailto:support@sms-gate.app)

---

## External Resources
- **Project Website**: [sms-gate.app](https://sms-gate.app)
- **Source Repository**: [capcom6/android-sms-gateway](https://github.com/capcom6/android-sms-gateway)
- **Official Documentation**: [docs.sms-gate.app](https://docs.sms-gate.app)

<p align="center">Developed in the Philippines</p>
