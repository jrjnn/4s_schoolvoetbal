using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace _4sgokken
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void txbGebruikersNaam_TextChanged(object sender, EventArgs e)
        {
            inputGebruikersNaam.Text = txbGebruikersNaam.Text;
        }

        private void txbWachtwoord_TextChanged(object sender, EventArgs e)
        {
            inputWaarwoord.Text = txbWachtwoord.Text;
        }

        private void btnInloggen_Click(object sender, EventArgs e)
        {
            if (txbGebruikersNaam.Text == "admin" && txbWachtwoord.Text == "admin")
            {
                MessageBox.Show("Welkom!");
                Form2 form2 = new Form2();
                form2.Show();
                this.Hide();
            }
            else
            {
                MessageBox.Show("Gebruikersnaam of wachtwoord is incorrect!");
            }

            {

            }

        }

        private void btnRegistreren_Click(object sender, EventArgs e)
        {
               Form3 form3 = new Form3();
                form3.Show();
                this.Hide();
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {
            throw new System.NotImplementedException();
        }
    }
}
