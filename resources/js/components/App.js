import React from "react";
import ReactDOM from "react-dom";

export default class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name_th: "",
            name_en: "",
            selectedStudent: "",
            students: [],
        };

        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.renderStudent = this.renderStudent.bind(this);
    }

    renderStudent() {
        return this.state.students.map((item) => (
            <option key={item.id} value={item.id}>
                {item.fname} {item.lname}
            </option>
        ));
    }

    handleInputChange(e) {
        const target = e.target;
        const val = target.value;
        const name = target.name;

        this.setState({
            [name]: val,
        });
    }

    handleSubmit(event) {
        alert("Your name_th is: " + this.state.name_th);
        event.preventDefault();
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <div className="form-group row">
                    <label
                        htmlFor="name_th"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        ชื่อโครงงานภาษาไทย :
                    </label>
                    <div className="col-md-6">
                        <input
                            id="name_th"
                            type="text"
                            required
                            className="form-control"
                            name="name_th"
                            value={this.state.name_th}
                            autoFocus
                            onChange={this.handleInputChange}
                        />
                    </div>
                </div>

                <div className="form-group row">
                    <label
                        htmlFor="name_en"
                        className="col-md-4 col-form-label text-md-right"
                    >
                        ชื่อโครงงานภาษาอังกฤษ :
                    </label>
                    <div className="col-md-6">
                        <input
                            id="name_en"
                            type="text"
                            required
                            className="form-control"
                            name="name_en"
                            value={this.state.name_en}
                            autoFocus
                            onChange={this.handleInputChange}
                        />
                    </div>
                </div>

                <div className="student-container">
                    <div className="form-group row">
                        <label
                            htmlFor="student"
                            className="col-md-4 col-form-label text-md-right"
                        >
                            นักศึกษา :{" "}
                        </label>
                        <div className="col-md-6">
                            <select
                                value={this.state.selectedStudent}
                                onChange={this.handleInputChange}
                                className="form-control"
                            ></select>
                        </div>
                        <a
                            href="#"
                            id="add-student"
                            className="btn btn-primary"
                        >
                            เพิ่ม
                        </a>
                    </div>
                </div>

                <div className="container">
                    <div className="col-md-12 text-center">
                        <button type="submit" className="btn btn-success">
                            บันทึก
                        </button>
                        <a href="/home" className="btn btn-ligth">
                            ยกเลิก
                        </a>
                    </div>
                </div>
            </form>
        );
    }
}
