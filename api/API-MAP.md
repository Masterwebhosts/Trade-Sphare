# Trade Sphare API — Architecture Map

## Project
Trade Sphare Advertising Platform

## API Version
v1

## Purpose
Secure integration layer for approved external systems.

## Current Integration
Blog system — manually approved integration.

## Architecture
External System
    ↓ HTTPS
API v1
    ↓
Authentication
    ↓
Authorization
    ↓
Controllers
    ↓
Services
    ↓
Existing Trade Sphare Core

## Rules
- API is independent from the Blog system.
- Blog and Trade Sphare remain separate projects.
- No shared database.
- No direct database access from external systems.
- Integration must be manually approved by Admin.
- API versioning starts with v1.
- Existing advertising system remains the source of truth.

## Planned API Domains
- Authentication
- Publisher Integration
- Ad Zones
- Ad Serving
- Impression Tracking
- Click Tracking
- Integration Management
- Health / Status

## Existing API
routes/api.php

## New API
routes/api_v1.php
