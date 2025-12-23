
import Excel from 'exceljs';

export class ExportExcel {


    public headers: string[] = [];
    public rows: (number | string)[] = [];
    public footers: (number | string)[] = [];
    public workbook: Excel.Workbook;
    public sheet: Excel.Worksheet;

    public constructor(
        data: { headers: string[], list: (number | string)[], footers: (number | string)[] }
    ) {

        this.workbook = new Excel.Workbook();
        this.sheet = this.workbook.addWorksheet('My Sheet');
        this.headers = data.headers;
        this.rows = data.list;
        this.footers = data.footers;

    }

    public addHeaders() {


        const row = this.sheet.addRow(this.headers);

         row.font = { name: 'Arial Black', bold: true };

    }

    public addRows() {
        this.sheet.addRows(this.rows);
    }

    public addFooters() {
        const row = this.sheet.addRow(this.footers);
        row.font = { name: 'Arial Black', bold: true };
    }


    public generate() {
        this.addHeaders();
        this.addRows();
        this.addFooters();
    }

    public async download() {

        this.generate();





        try {

            const buffer = await this.workbook.xlsx.writeBuffer();
            const fileName = 'salarysheet'

            // build anchor tag and attach file (works in chrome)
            var a = document.createElement("a");
            var data = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });

            var url = URL.createObjectURL(data);
            a.href = url;
            a.download = `${fileName}.xlsx`;
            document.body.appendChild(a);
            a.click();
            setTimeout(function () {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            },
                0);

        } catch (error: any) {
            console.log(error.message);
        }






    }

}