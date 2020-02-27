import { Component, OnInit } from "@angular/core";
import { DataService } from "src/app/services/data.service";

@Component({
  selector: "app-main",
  templateUrl: "./main.component.html",
  styleUrls: ["./main.component.scss"]
})
export class MainComponent implements OnInit {
  studInfo: any = {};
  students: any;

  constructor(private ds: DataService) { }

  ngOnInit() {
    this.getStudents();
  }

  getStudents() {
    this.ds.sendApiRequest("getStudents", null).subscribe(data => {
      this.students = data.data;
    });
  }

  async addStudent(e) {
    e.preventDefault();

    this.studInfo.studName = e.target.elements[0].value;
    this.studInfo.studAddress = e.target.elements[1].value;
    this.studInfo.studNo = e.target.elements[2].value;
    await this.ds.sendApiRequest("addStudent", this.studInfo).subscribe(res => {
      console.log(res);

      this.getStudents();
    });
  }

  async deleteStudent(e) {
    this.studInfo.studRecno = e;
    await this.ds.sendApiRequest("deleteStudent", this.studInfo).subscribe(res => {
      if (res.status.remarks) {
        this.getStudents();
      }

    });
  }

  async updateStudent(e) {
    e.preventDefault();
    await this.ds.sendApiRequest("updateStudent", this.studInfo).subscribe(res => {
      if (res.status.remarks) {
        this.getStudents();
      }
    });
  }

  //es6 format
  updateForm = (student) => {
    this.studInfo.studRecno1 = student.stud_recno;
    this.studInfo.studName1 = student.stud_name;
    this.studInfo.studAddress1 = student.stud_address;
    this.studInfo.studContactNo1 = student.stud_number;


  }
}
