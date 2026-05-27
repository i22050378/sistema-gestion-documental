using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using SistemaGestion.Models;

namespace SistemaGestion.Controllers
{
    public class HomeController : Controller
    {
        private readonly AppDbContext _context;

        public HomeController(AppDbContext context)
        {
            _context = context;
        }

        public async Task<IActionResult> Index()
        {
            var documentos = await _context.Documentos
                .Include(d => d.Creador)
                .OrderByDescending(d => d.FechaCreacion)
                .ToListAsync();

            return View(documentos);
        }
    }
}