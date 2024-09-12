<x-filament-panels::page>
    <div class="px-6 py-3 bg-white rounded-lg shadow-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Account Details</h2>
        <table class="w-full table-fixed">
            <tbody>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Full Name:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['first_name'].' '.$profile['middle_name'].' '.$profile['last_name'].' '.$profile['name_suffix']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Phone Number:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['mobile']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Email:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['email']}}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-white rounded-lg shadow-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Customer Info Sheet Details</h2>
        <table class="w-full table-auto">
            <tbody>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Full Name:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['first_name'].' '.$profile['middle_name'].' '.$profile['last_name'].' '.$profile['name_suffix']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Date of Birth:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['date_of_birth']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Email:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['email']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Nationality:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['nationality']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Gender:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['sex']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Civil Status:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{$profile['civil_status']}}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-white rounded-lg shadow-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Present Address</h2>
        <table class="w-full table-auto">
            <tbody>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Region:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['region']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Province:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['administrative_area']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">City/Town:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['locality']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Barangay:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['sublocality']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Zip Code:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['postal_code']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Home Ownership:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['ownership']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Years Stayed in the Current Address:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($addresses)->firstWhere('type', 'Present')['length_of_stay']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Permanent Address:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($addresses)->firstWhere('type', 'Present') == collect($addresses)->firstWhere('type', 'Permanent') ? 'Yes' : 'No' }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-white rounded-lg shadow-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Employment Information</h2>
        <table class="w-full table-auto">
            <tbody>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Type:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['employment_type']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Status:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['employment_status']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Tenure:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['years_in_service']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Current Position:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['current_position']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Rank:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['rank']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Industry:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{collect($employment)->firstWhere('type', 'buyer')['industry']}}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Gross Monthly Income:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">₱{{ number_format(collect($employment)->firstWhere('type', 'buyer')['monthly_gross_income'], 2) }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Tax Identification Number:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['id']['tin'] }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Pag-Ibig Number:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['id']['pagibig'] }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">SSS/GSIS Number:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['id']['sss'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-white rounded-lg shadow-lg w-full">
        <h2 class="text-lg font-semibold mb-4">Employer Details</h2>
        <table class="w-full table-auto">
            <tbody>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Employer/Business Name:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['employer']['name'] }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Year Established:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['employer']['year_established'] }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Email:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['employer']['email'] }}</td>
            </tr>
            <tr>
                <td class="font-medium text-dark-700 text-left w-1/2 md:w-1/4">Address:</td>
                <td class="text-gray-900 text-left w-1/2 md:w-3/4">{{ collect($employment)->firstWhere('type', 'buyer')['employer']['address']['full_address'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
