# Routing Shipment Destinations to Drivers

This PHP application is designed to assign shipment destinations to drivers in a way that maximizes the total suitability score (SS) over the set of drivers. The program takes two input files: one containing the street addresses of the shipment destinations and another containing the names of the drivers. The output includes the total SS and the matching between shipment destinations and drivers.

## Prerequisites

Before running the application, ensure that you have the following installed:

- PHP (version 7.0 or higher)
- Command-line interface (CLI) access

## Installation

1. Clone the repository from [GitHub](hhttps://github.com/omaribarra-dev/exam.git).

   ```bash
   git clone https://github.com/omaribarra-dev/exam.git

## Usage

1. Place the shipment destinations in a newline-separated file named `destinations.txt`. Each line should contain a single destination address.
2. Place the driver names in a newline-separated file named `drivers.txt`. Each line should contain a single driver name.
3. Run the application from the command line.

   ```bash
   php index.php