import { HttpClient } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormGroup,FormControl,Validators } from "@angular/forms";
import { ToastrService } from 'ngx-toastr';
import { SharingService } from '../shared/sharingdata.service';

@Component({
  selector: 'app-careers',
  templateUrl: './careers.component.html',
  styleUrls: ['./careers.component.scss']
})
export class CareersComponent implements OnInit {

  title:string = "Careers";
  message:string;

  constructor(private _http:HttpClient,private toastr:ToastrService,private service:SharingService ) { }

  ngOnInit() {
    this.service.currentMessage.subscribe(message => this.message = message);
    this.service.changeMessage("true");
  }

  form = new FormGroup({
    userName:new FormControl("",[
      Validators.required,
      Validators.pattern("[A-Za-z ]{3,50}")
    ]),
    userMail:new FormControl("",[
      Validators.required,
      Validators.pattern("[^ @]*@[^ @]*")
    ]),
    position:new FormControl("",[
      Validators.required,
      Validators.pattern("[A-Za-z ]{3,50}")
    ]),
    message:new FormControl("",[
      Validators.required,
    ])
  })

//upload
  selectedFile:File = null;

  fileUpload(event)
   {
   this.selectedFile = event.target.files[0];
  //  let fileName:string = this.selectedFile = event.target.files[0].name;
  //  let fileExtention = fileName.slice(fileName.indexOf(".")+1);
  //  let filesExtention =['pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'];
   }


  onSubmit(){
    let s = this.form.value.userName;
    let a = this.form.value.userMail;
    let b = this.form.value.position;
    let d = this.form.value.message;
 
    //upload
    const formd = new FormData();
    formd.append("file",this.selectedFile);
    //console.log(formd.get("file"));
    formd.append("username",s);
    formd.append("userMail",a);
    formd.append("position",b);
    formd.append("message",d);

    
    this._http.post("http://www.code.com/carrers.php",formd).subscribe((data) => 
    {
      console.log(data);
    });
    
    this.form.reset();
    this.toastr.success('Sended Successfully ', 'Message');
    
   }


   
 

}
