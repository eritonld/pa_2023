<style>
        /* Style the border of the table */
        .table-border {
            border: 1px solid #000; /* Set the border color and width */
            border-collapse: collapse; /* Collapse the borders to prevent spacing */
        }

        /* Style the table header cells */
        .table-border th {
            border: 1px solid #000; /* Set the border color and width */
            background-color: #f2f2f2; /* Add a background color */
            text-align: center; /* Center-align the text */
        }

        /* Style the table data cells */
        .table-border td {
            border: 1px solid #000; /* Set the border color and width */
        }
    </style>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12">
        <table class="table table-border">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Indicator</th>
                </tr>
            </thead>
			<?php if($bahasa=='eng'){ ?>
            <tbody>
                <tr>
                    <td style="vertical-align: middle;">Expert</td>
                    <td>Shows consistent ability to demonstrate the behavior in any projects and/or within the organization, while also influencing others to do so.</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Advanced</td>
                    <td>Consistently and independently demonstrate the behavior and being acknowledged within the organization</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Practitioner</td>
                    <td>Able to demonstrate the competency in consistent manner while still need direction to success</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Comprehension</td>
                    <td>Start to have a complex understanding and be able to discuss terminology, concepts, and all related things around that</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Basic</td>
                    <td>Understand but is not able yet to demonstrate</td>
                </tr>
            </tbody>
			<?php }else{ ?>
			<tbody>
                <tr>
                    <td style="vertical-align: middle;">Expert</td>
                    <td>Menunjukkan keunggulan yang konsisten dalam menerapkan hal ini di berbagai proyek dan/ atau organisasi dan mengajak orang lain melakukan hal tersebut</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Advanced</td>
                    <td>Dapat secara konsisten dan mandiri melakukan hal ini dan Diakui di dalam organisasi</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Practitioner</td>
                    <td>Mampu mengaplikasikan kompetensi ini secara berkala sambil membutuhkan arahan untuk berhasil</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Comprehension</td>
                    <td>Sudah mulai memahami dan mampu berdiskusi tentang terminologi, konsep, dan hal-hal yang terkait dengan hal tersebut</td>
                </tr>
                <tr>
                    <td style="vertical-align: middle;">Basic</td>
                    <td>Tahu namun belum bisa mempraktekkan</td>
                </tr>
            </tbody>
			<?php }  ?>
        </table>
    </div>
</div>